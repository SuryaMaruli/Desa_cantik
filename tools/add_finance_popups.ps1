$path = 'D:\Aplikasi Pengelola Keuangan.py'
$content = Get-Content -Raw -LiteralPath $path

$popupBlock = @'

# =========================================================
# POPUP INTERAKTIF
# =========================================================
def tampilkan_notifikasi_aksi():
    pesan = st.session_state.pop("notifikasi_aksi", None)

    if pesan:
        st.toast(pesan, icon="✅")
        st.success(pesan)


def siapkan_popup_aksi(nama_aksi, payload):
    st.session_state["popup_aksi"] = {
        "nama": nama_aksi,
        "payload": payload,
    }


@st.dialog("Konfirmasi Aksi")
def popup_konfirmasi_aksi():
    aksi = st.session_state.get("popup_aksi")

    if not aksi:
        st.info("Tidak ada aksi yang perlu dikonfirmasi.")
        if st.button("Tutup", use_container_width=True):
            st.rerun()
        return

    nama_aksi = aksi["nama"]
    payload = aksi["payload"]

    if nama_aksi == "tambah":
        st.subheader("Simpan transaksi baru?")
        st.write(f"**Jenis:** {payload['jenis']}")
        st.write(f"**Tanggal:** {payload['tanggal'].strftime('%d-%m-%Y')}")
        st.write(f"**Kategori:** {payload['kategori']}")
        st.write(f"**Nominal:** {rupiah(payload['nominal'])}")
        st.write(f"**Keterangan:** {payload['keterangan'] or '-'}")

        col_batal, col_lanjut = st.columns(2)
        with col_batal:
            if st.button("Batal", use_container_width=True):
                st.session_state.pop("popup_aksi", None)
                st.rerun()
        with col_lanjut:
            if st.button("Ya, simpan", type="primary", use_container_width=True):
                tambah_transaksi(
                    payload["tanggal"],
                    payload["jenis"],
                    payload["kategori"],
                    payload["nominal"],
                    payload["keterangan"],
                )
                st.session_state.pop("popup_aksi", None)
                st.session_state["notifikasi_aksi"] = "Transaksi berhasil disimpan."
                st.rerun()

    elif nama_aksi == "edit":
        st.subheader("Simpan perubahan transaksi?")
        st.write(f"**ID:** {payload['transaction_id']}")
        st.write(f"**Jenis:** {payload['jenis']}")
        st.write(f"**Tanggal:** {payload['tanggal'].strftime('%d-%m-%Y')}")
        st.write(f"**Kategori:** {payload['kategori']}")
        st.write(f"**Nominal:** {rupiah(payload['nominal'])}")
        st.write(f"**Keterangan:** {payload['keterangan'] or '-'}")

        col_batal, col_lanjut = st.columns(2)
        with col_batal:
            if st.button("Batal", use_container_width=True):
                st.session_state.pop("popup_aksi", None)
                st.rerun()
        with col_lanjut:
            if st.button("Ya, perbarui", type="primary", use_container_width=True):
                ubah_transaksi(
                    payload["transaction_id"],
                    payload["tanggal"],
                    payload["jenis"],
                    payload["kategori"],
                    payload["nominal"],
                    payload["keterangan"],
                )
                st.session_state.pop("popup_aksi", None)
                st.session_state["notifikasi_aksi"] = "Transaksi berhasil diperbarui."
                st.rerun()

    elif nama_aksi == "hapus":
        st.subheader("Hapus transaksi ini?")
        st.warning("Aksi ini permanen dan data tidak dapat dikembalikan.")
        st.write(f"**ID:** {payload['transaction_id']}")
        st.write(f"**Kategori:** {payload['kategori']}")
        st.write(f"**Nominal:** {rupiah(payload['nominal'])}")

        col_batal, col_lanjut = st.columns(2)
        with col_batal:
            if st.button("Batal", use_container_width=True):
                st.session_state.pop("popup_aksi", None)
                st.rerun()
        with col_lanjut:
            if st.button("Ya, hapus", type="primary", use_container_width=True):
                hapus_transaksi(payload["transaction_id"])
                st.session_state.pop("popup_aksi", None)
                st.session_state["notifikasi_aksi"] = "Transaksi berhasil dihapus."
                st.rerun()
'@

$content = $content.Replace(
    "# =========================================================`r`n# INISIALISASI`r`n# =========================================================",
    "$popupBlock`r`n`r`n# =========================================================`r`n# INISIALISASI`r`n# ========================================================="
)

$content = $content.Replace(
    "init_database()`r`ndf_semua = baca_transaksi()",
    "init_database()`r`ntampilkan_notifikasi_aksi()`r`nif st.session_state.get(`"popup_aksi`"):`r`n    popup_konfirmasi_aksi()`r`ndf_semua = baca_transaksi()"
)

$content = $content.Replace(
@'
        if simpan:
            tambah_transaksi(
                tanggal,
                jenis,
                kategori,
                nominal,
                keterangan,
            )

            st.success(
                "Transaksi berhasil disimpan."
            )
            st.rerun()
'@,
@'
        if simpan:
            siapkan_popup_aksi(
                "tambah",
                {
                    "tanggal": tanggal,
                    "jenis": jenis,
                    "kategori": kategori,
                    "nominal": nominal,
                    "keterangan": keterangan,
                },
            )
            popup_konfirmasi_aksi()
'@
)

$content = $content.Replace(
@'
            csv_rekap = (
                rekap.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.download_button(
'@,
@'
            csv_rekap = (
                rekap.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.info("Klik tombol unduh untuk menyimpan rekap bulanan sebagai CSV.")

            st.download_button(
'@
)

$content = $content.Replace(
@'
            csv = (
                df_filter.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.download_button(
'@,
@'
            csv = (
                df_filter.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.info("Klik tombol unduh untuk menyimpan riwayat transaksi sebagai CSV.")

            st.download_button(
'@
)

$content = $content.Replace(
@'
            if simpan_perubahan:
                ubah_transaksi(
                    transaction_id,
                    tanggal_baru,
                    jenis_baru,
                    kategori_baru,
                    nominal_baru,
                    keterangan_baru,
                )

                st.success(
                    "Transaksi berhasil diperbarui."
                )
                st.rerun()
'@,
@'
            if simpan_perubahan:
                siapkan_popup_aksi(
                    "edit",
                    {
                        "transaction_id": transaction_id,
                        "tanggal": tanggal_baru,
                        "jenis": jenis_baru,
                        "kategori": kategori_baru,
                        "nominal": nominal_baru,
                        "keterangan": keterangan_baru,
                    },
                )
                popup_konfirmasi_aksi()
'@
)

$content = $content.Replace(
@'
            if st.button(
                "Hapus Transaksi",
                disabled=not konfirmasi,
                use_container_width=True,
                type="secondary",
            ):
                hapus_transaksi(
                    transaction_id
                )
                st.success(
                    "Transaksi berhasil dihapus."
                )
                st.rerun()
'@,
@'
            if st.button(
                "Hapus Transaksi",
                disabled=not konfirmasi,
                use_container_width=True,
                type="secondary",
            ):
                siapkan_popup_aksi(
                    "hapus",
                    {
                        "transaction_id": transaction_id,
                        "kategori": data_lama["kategori"],
                        "nominal": data_lama["nominal"],
                    },
                )
                popup_konfirmasi_aksi()
'@
)

Set-Content -LiteralPath $path -Value $content -Encoding UTF8
