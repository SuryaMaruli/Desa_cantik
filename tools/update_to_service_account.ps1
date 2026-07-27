$path = 'D:\AplikasiKeuangan\Aplikasi Pengelola Keuangan.py'
$content = [System.IO.File]::ReadAllText($path)
$nl = [Environment]::NewLine

$content = $content.Replace("import json$nl", "")
$content = $content.Replace("from urllib.request import urlopen$nl", "")
$content = $content.Replace(
    "import streamlit as st$nl",
    "import streamlit as st$nl" +
    "from google.auth.transport.requests import AuthorizedSession$nl" +
    "from google.oauth2 import service_account$nl"
)

$replacementFetch = @'
def get_service_account_info():
    try:
        info = dict(st.secrets["gcp_service_account"])
    except Exception:
        return None

    if info.get("private_key"):
        info["private_key"] = info["private_key"].replace("\\n", "\n")
    return info


def get_spreadsheet_id(default=""):
    try:
        spreadsheet = st.secrets.get("spreadsheet", {})
        return spreadsheet.get("id", default)
    except Exception:
        return default


def create_authorized_session(service_account_info):
    credentials = service_account.Credentials.from_service_account_info(
        service_account_info,
        scopes=["https://www.googleapis.com/auth/spreadsheets.readonly"],
    )
    return AuthorizedSession(credentials)


@st.cache_data(ttl=300, show_spinner=False)
def fetch_values(spreadsheet_id, range_name, _session):
    url = (
        "https://sheets.googleapis.com/v4/spreadsheets/"
        f"{spreadsheet_id}/values/{quote(range_name)}"
    )
    response = _session.get(url, timeout=20)
    if not response.ok:
        raise RuntimeError(
            f"Google Sheets API error {response.status_code}: {response.text}"
        )
    return response.json().get("values", [])


def values_to_df
'@

$content = [regex]::Replace(
    $content,
    '(?ms)^@st\.cache_data\(ttl=300, show_spinner=False\)\r?\ndef fetch_values\(spreadsheet_id, api_key, range_name\):.*?^def values_to_df',
    $replacementFetch
)

$replacementLoad = @'
def load_spreadsheet(spreadsheet_id, session):
    transaksi = values_to_df(
        fetch_values(spreadsheet_id, TRANSAKSI_RANGE, session),
        TRANSAKSI_COLUMNS,
    )
    kategori = values_to_df(
        fetch_values(spreadsheet_id, KATEGORI_RANGE, session),
        KATEGORI_COLUMNS,
    )
    return prepare_transaksi(transaksi), prepare_kategori(kategori)


def filter_data
'@

$content = [regex]::Replace(
    $content,
    '(?ms)^def load_spreadsheet\(spreadsheet_id, api_key\):.*?^def filter_data',
    $replacementLoad
)

$content = $content.Replace(
    'Masukkan API key dan Spreadsheet ID/URL di sidebar. API key tidak bisa mencari spreadsheet hanya dari judul.',
    'Aplikasi membaca Google Spreadsheet memakai Service Account dari Streamlit Secrets.'
)
$content = $content.Replace(
    'Pastikan spreadsheet bisa dibaca oleh API key, misalnya akses link publik atau konfigurasi API yang sesuai.',
    'Pastikan spreadsheet sudah dibagikan ke email service account pada field client_email.'
)
$content = $content.Replace(
    'Hubungkan dashboard dengan Google Spreadsheet.',
    'Hubungkan dashboard dengan Google Spreadsheet melalui Service Account.'
)

$replacementSidebar = @'
with st.sidebar:
    st.markdown(
        """
        <div class="sidebar-brand">
            <div class="sidebar-brand-title">Monitoring Keuangan</div>
            <div class="sidebar-brand-subtitle">Data langsung dari Google Spreadsheet.</div>
        </div>
        <div class="sidebar-section-label">Koneksi Spreadsheet</div>
        """,
        unsafe_allow_html=True,
    )
    service_account_info = get_service_account_info()
    default_sheet_id = get_spreadsheet_id("")
    sheet_input = st.text_input("Spreadsheet ID atau URL", value=default_sheet_id)
    spreadsheet_id = extract_spreadsheet_id(sheet_input)
    if service_account_info:
        st.success("Service account terdeteksi dari Secrets.")
        st.caption(f"Email service account: {service_account_info.get('client_email', '-')}")
    else:
        st.warning("Secrets gcp_service_account belum ditemukan.")
    st.caption(f"Judul spreadsheet: {APP_TITLE}")
    if st.button("Muat ulang data", use_container_width=True):
        st.cache_data.clear()

    menu = st.radio(
        "Menu",
        ["Dashboard", "Data Transaksi", "Kategori", "Panduan"],
        format_func=lambda item: {
            "Dashboard": "Dashboard  |  Visualisasi",
            "Data Transaksi": "Transaksi  |  Tabel data",
            "Kategori": "Kategori  |  Referensi",
            "Panduan": "Panduan  |  Setup",
        }[item],
        label_visibility="collapsed",
    )


if not service_account_info or not spreadsheet_id:
'@

$content = [regex]::Replace(
    $content,
    '(?ms)^with st\.sidebar:\r?\n    st\.markdown\(\r?\n        """\r?\n        <div class="sidebar-brand">.*?^\r?\n\r?\nif not api_key or not spreadsheet_id:',
    $replacementSidebar
)

$content = $content.Replace(
    'df_semua, df_kategori = load_spreadsheet(spreadsheet_id, api_key)',
    "session = create_authorized_session(service_account_info)$nl        df_semua, df_kategori = load_spreadsheet(spreadsheet_id, session)"
)
$content = $content.Replace(
    'st.info("Periksa API key, Spreadsheet ID/URL, nama sheet, dan akses spreadsheet.")',
    'st.info("Periksa Secrets gcp_service_account, spreadsheet.id, nama sheet, dan pastikan spreadsheet sudah di-share ke client_email service account.")'
)

[System.IO.File]::WriteAllText($path, $content, [System.Text.UTF8Encoding]::new($false))
