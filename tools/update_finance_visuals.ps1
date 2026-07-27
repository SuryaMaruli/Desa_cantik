$path = 'D:\Aplikasi Pengelola Keuangan.py'
$content = Get-Content -Raw -LiteralPath $path

$oldImport = 'import plotly.express as px'
$newImport = @'
import plotly.express as px
import plotly.graph_objects as go
'@
$content = $content.Replace($oldImport, $newImport)

$start = $content.IndexOf('def format_plotly(fig):')
$end = $content.IndexOf('def rekap_bulanan(df):')
if ($start -lt 0 -or $end -lt 0 -or $end -le $start) {
    throw 'Tidak bisa menemukan blok fungsi grafik.'
}

$newVisualFunctions = @'
def format_plotly(fig, tinggi=420):
    fig.update_layout(
        template="plotly_white",
        height=tinggi,
        margin=dict(l=20, r=20, t=65, b=25),
        paper_bgcolor="rgba(0,0,0,0)",
        plot_bgcolor="rgba(248,250,252,0.72)",
        hoverlabel=dict(
            bgcolor="white",
            bordercolor="#cbd5e1",
            font_size=12,
            font_family="Arial",
        ),
        font=dict(
            family="Arial",
            size=12,
            color="#334155",
        ),
        title_font=dict(
            size=18,
            color="#0f172a",
        ),
        legend_title_text="",
        legend=dict(
            orientation="h",
            yanchor="bottom",
            y=1.02,
            xanchor="right",
            x=1,
        ),
    )

    fig.update_xaxes(
        showgrid=True,
        gridcolor="#e2e8f0",
        zeroline=False,
    )
    fig.update_yaxes(
        showgrid=True,
        gridcolor="#e2e8f0",
        zeroline=False,
    )
    return fig


def tampilkan_plotly(fig, tinggi=420):
    st.plotly_chart(
        format_plotly(fig, tinggi),
        use_container_width=True,
        config={
            "displaylogo": False,
            "modeBarButtonsToRemove": [
                "lasso2d",
                "select2d",
            ],
        },
    )


def grafik_kategori(df, jenis):
    data = (
        df[df["jenis"] == jenis]
        .groupby("kategori", as_index=False)["nominal"]
        .sum()
        .sort_values("nominal", ascending=True)
    )

    if data.empty:
        st.info(
            f"Belum ada data {jenis.lower()} pada periode terpilih."
        )
        return

    fig = px.bar(
        data,
        x="nominal",
        y="kategori",
        orientation="h",
        text="nominal",
        title=f"{jenis} per Kategori",
        labels={
            "kategori": "",
            "nominal": "Nominal",
        },
        color="nominal",
        color_continuous_scale=(
            "Greens" if jenis == "Pemasukan" else "Reds"
        ),
        custom_data=["kategori"],
    )

    fig.update_traces(
        texttemplate="Rp %{text:,.0f}",
        textposition="outside",
        cliponaxis=False,
        hovertemplate=(
            "<b>%{customdata[0]}</b><br>"
            "Total: Rp %{x:,.0f}"
            "<extra></extra>"
        ),
    )

    fig.update_layout(
        xaxis_tickprefix="Rp ",
        xaxis_tickformat=",.0f",
        coloraxis_showscale=False,
        showlegend=False,
    )

    tampilkan_plotly(fig)


def grafik_komposisi(df, jenis):
    data = (
        df[df["jenis"] == jenis]
        .groupby("kategori", as_index=False)["nominal"]
        .sum()
        .sort_values("nominal", ascending=False)
    )

    if data.empty:
        st.info(
            f"Belum ada data {jenis.lower()} untuk grafik komposisi."
        )
        return

    fig = px.pie(
        data,
        names="kategori",
        values="nominal",
        hole=0.58,
        title=f"Komposisi {jenis}",
        color_discrete_sequence=px.colors.qualitative.Set3,
    )

    fig.update_traces(
        textposition="inside",
        textinfo="percent",
        pull=[0.06 if i == 0 else 0 for i in range(len(data))],
        marker=dict(
            line=dict(color="white", width=2),
        ),
        hovertemplate=(
            "<b>%{label}</b><br>"
            "Nominal: Rp %{value:,.0f}<br>"
            "Porsi: %{percent}"
            "<extra></extra>"
        ),
    )

    fig.update_layout(
        legend=dict(
            orientation="h",
            yanchor="bottom",
            y=-0.24,
            xanchor="center",
            x=0.5,
        )
    )

    tampilkan_plotly(fig)


def grafik_bulanan(df):
    if df.empty:
        st.info("Belum ada data untuk grafik bulanan.")
        return

    data = df.copy()
    data["bulan"] = (
        data["tanggal"]
        .dt.to_period("M")
        .dt.to_timestamp()
    )

    bulanan = (
        data.groupby(
            ["bulan", "jenis"],
            as_index=False,
        )["nominal"]
        .sum()
        .pivot(
            index="bulan",
            columns="jenis",
            values="nominal",
        )
        .fillna(0)
        .reset_index()
        .sort_values("bulan")
    )

    if "Pemasukan" not in bulanan.columns:
        bulanan["Pemasukan"] = 0

    if "Pengeluaran" not in bulanan.columns:
        bulanan["Pengeluaran"] = 0

    bulanan["Saldo"] = (
        bulanan["Pemasukan"]
        - bulanan["Pengeluaran"]
    )

    fig = go.Figure()

    fig.add_trace(
        go.Bar(
            x=bulanan["bulan"],
            y=bulanan["Pemasukan"],
            name="Pemasukan",
            marker_color=WARNA_JENIS["Pemasukan"],
            opacity=0.82,
            hovertemplate=(
                "Bulan: %{x|%b %Y}<br>"
                "Pemasukan: Rp %{y:,.0f}"
                "<extra></extra>"
            ),
        )
    )
    fig.add_trace(
        go.Bar(
            x=bulanan["bulan"],
            y=bulanan["Pengeluaran"],
            name="Pengeluaran",
            marker_color=WARNA_JENIS["Pengeluaran"],
            opacity=0.82,
            hovertemplate=(
                "Bulan: %{x|%b %Y}<br>"
                "Pengeluaran: Rp %{y:,.0f}"
                "<extra></extra>"
            ),
        )
    )
    fig.add_trace(
        go.Scatter(
            x=bulanan["bulan"],
            y=bulanan["Saldo"],
            name="Saldo",
            mode="lines+markers",
            line=dict(
                color=WARNA_JENIS["Saldo"],
                width=4,
                shape="spline",
            ),
            marker=dict(size=9),
            hovertemplate=(
                "Bulan: %{x|%b %Y}<br>"
                "Saldo: Rp %{y:,.0f}"
                "<extra></extra>"
            ),
        )
    )

    fig.update_layout(
        title="Tren Keuangan Bulanan",
        barmode="group",
        hovermode="x unified",
        yaxis_tickprefix="Rp ",
        yaxis_tickformat=",.0f",
    )
    fig.update_xaxes(
        tickformat="%b %Y",
        rangeslider=dict(visible=True),
    )

    tampilkan_plotly(fig, tinggi=470)


def grafik_pengeluaran_harian(df):
    pengeluaran = df[df["jenis"] == "Pengeluaran"].copy()

    if pengeluaran.empty:
        st.info("Belum ada data pengeluaran harian pada periode terpilih.")
        return

    harian = (
        pengeluaran.groupby(
            pengeluaran["tanggal"].dt.date,
            as_index=False,
        )["nominal"]
        .sum()
        .rename(columns={"tanggal": "Tanggal", "nominal": "Pengeluaran"})
    )
    harian["Tanggal"] = pd.to_datetime(harian["Tanggal"])
    harian = harian.sort_values("Tanggal")
    harian["Rata-rata 7 Hari"] = (
        harian["Pengeluaran"]
        .rolling(window=7, min_periods=1)
        .mean()
    )

    fig = go.Figure()
    fig.add_trace(
        go.Scatter(
            x=harian["Tanggal"],
            y=harian["Pengeluaran"],
            name="Pengeluaran Harian",
            mode="lines+markers",
            fill="tozeroy",
            line=dict(
                color=WARNA_JENIS["Pengeluaran"],
                width=3,
                shape="spline",
            ),
            marker=dict(size=7),
            hovertemplate=(
                "Tanggal: %{x|%d-%m-%Y}<br>"
                "Pengeluaran: Rp %{y:,.0f}"
                "<extra></extra>"
            ),
        )
    )
    fig.add_trace(
        go.Scatter(
            x=harian["Tanggal"],
            y=harian["Rata-rata 7 Hari"],
            name="Rata-rata 7 Hari",
            mode="lines",
            line=dict(
                color="#7c3aed",
                width=3,
                dash="dot",
                shape="spline",
            ),
            hovertemplate=(
                "Tanggal: %{x|%d-%m-%Y}<br>"
                "Rata-rata: Rp %{y:,.0f}"
                "<extra></extra>"
            ),
        )
    )

    fig.update_layout(
        title="Pengeluaran Tiap Hari",
        hovermode="x unified",
        yaxis_tickprefix="Rp ",
        yaxis_tickformat=",.0f",
    )
    fig.update_xaxes(
        tickformat="%d %b",
        rangeslider=dict(visible=True),
    )

    tampilkan_plotly(fig, tinggi=450)


def grafik_pengeluaran_bulanan(df):
    pengeluaran = df[df["jenis"] == "Pengeluaran"].copy()

    if pengeluaran.empty:
        st.info("Belum ada data pengeluaran bulanan pada periode terpilih.")
        return

    pengeluaran["bulan"] = (
        pengeluaran["tanggal"]
        .dt.to_period("M")
        .dt.to_timestamp()
    )

    bulanan = (
        pengeluaran.groupby("bulan", as_index=False)["nominal"]
        .sum()
        .sort_values("bulan")
        .rename(columns={"nominal": "Pengeluaran"})
    )

    fig = px.bar(
        bulanan,
        x="bulan",
        y="Pengeluaran",
        text="Pengeluaran",
        title="Pengeluaran Tiap Bulan",
        labels={
            "bulan": "",
            "Pengeluaran": "Pengeluaran",
        },
        color="Pengeluaran",
        color_continuous_scale="Reds",
    )

    fig.update_traces(
        texttemplate="Rp %{text:,.0f}",
        textposition="outside",
        hovertemplate=(
            "Bulan: %{x|%b %Y}<br>"
            "Pengeluaran: Rp %{y:,.0f}"
            "<extra></extra>"
        ),
    )
    fig.update_layout(
        yaxis_tickprefix="Rp ",
        yaxis_tickformat=",.0f",
        coloraxis_showscale=False,
        showlegend=False,
    )
    fig.update_xaxes(tickformat="%b %Y")

    tampilkan_plotly(fig, tinggi=450)


def grafik_treemap_kategori(df, jenis):
    data = (
        df[df["jenis"] == jenis]
        .groupby("kategori", as_index=False)["nominal"]
        .sum()
        .sort_values("nominal", ascending=False)
    )

    if data.empty:
        st.info(f"Belum ada data {jenis.lower()} untuk treemap.")
        return

    fig = px.treemap(
        data,
        path=[px.Constant(jenis), "kategori"],
        values="nominal",
        color="nominal",
        color_continuous_scale=(
            "Greens" if jenis == "Pemasukan" else "Reds"
        ),
        title=f"Peta Besar Kategori {jenis}",
        custom_data=["kategori"],
    )
    fig.update_traces(
        texttemplate="<b>%{label}</b><br>Rp %{value:,.0f}",
        hovertemplate=(
            "<b>%{label}</b><br>"
            "Nominal: Rp %{value:,.0f}"
            "<extra></extra>"
        ),
        marker=dict(line=dict(color="white", width=2)),
    )
    fig.update_layout(coloraxis_showscale=False)

    tampilkan_plotly(fig)


'@

$content = $content.Substring(0, $start) + $newVisualFunctions + $content.Substring($end)

$oldDashboard = @'
            st.write("")
            section_header(
                "Perkembangan Keuangan",
                "Perbandingan pemasukan, pengeluaran, dan saldo per bulan.",
            )
            grafik_bulanan(df_filter)

            st.write("")
            section_header(
                "Analisis Pengeluaran",
                "Lihat kategori pengeluaran terbesar dan komposisinya.",
            )

            col1, col2 = st.columns([1.2, 1])

            with col1:
                grafik_kategori(
                    df_filter,
                    "Pengeluaran",
                )

            with col2:
                grafik_komposisi(
                    df_filter,
                    "Pengeluaran",
                )

            st.write("")
            section_header(
                "Analisis Pemasukan",
                "Lihat sumber pemasukan utama dan komposisinya.",
            )

            col3, col4 = st.columns([1.2, 1])

            with col3:
                grafik_kategori(
                    df_filter,
                    "Pemasukan",
                )

            with col4:
                grafik_komposisi(
                    df_filter,
                    "Pemasukan",
                )
'@

$newDashboard = @'
            st.write("")
            section_header(
                "Visualisasi Interaktif",
                "Gunakan hover, zoom, legend, dan range slider untuk menelusuri pola transaksi.",
            )

            tab_tren, tab_pengeluaran, tab_pemasukan = st.tabs(
                [
                    "Tren Keuangan",
                    "Pengeluaran",
                    "Pemasukan",
                ]
            )

            with tab_tren:
                grafik_bulanan(df_filter)

                col_harian, col_bulanan = st.columns(2)
                with col_harian:
                    grafik_pengeluaran_harian(df_filter)
                with col_bulanan:
                    grafik_pengeluaran_bulanan(df_filter)

            with tab_pengeluaran:
                col1, col2 = st.columns([1.15, 1])

                with col1:
                    grafik_kategori(
                        df_filter,
                        "Pengeluaran",
                    )

                with col2:
                    grafik_komposisi(
                        df_filter,
                        "Pengeluaran",
                    )

                grafik_treemap_kategori(
                    df_filter,
                    "Pengeluaran",
                )

            with tab_pemasukan:
                col3, col4 = st.columns([1.15, 1])

                with col3:
                    grafik_kategori(
                        df_filter,
                        "Pemasukan",
                    )

                with col4:
                    grafik_komposisi(
                        df_filter,
                        "Pemasukan",
                    )

                grafik_treemap_kategori(
                    df_filter,
                    "Pemasukan",
                )
'@

if (-not $content.Contains($oldDashboard)) {
    throw 'Tidak bisa menemukan blok dashboard lama.'
}

$content = $content.Replace($oldDashboard, $newDashboard)

Set-Content -LiteralPath $path -Value $content -Encoding UTF8
