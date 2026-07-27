$path = 'D:\Aplikasi Pengelola Keuangan.py'
$content = Get-Content -Raw -LiteralPath $path

$content = [regex]::Replace(
    $content,
    '(?ms)^        if simpan:\r?\n            tambah_transaksi\(\r?\n                tanggal,\r?\n                jenis,\r?\n                kategori,\r?\n                nominal,\r?\n                keterangan,\r?\n            \)\r?\n\r?\n            st\.success\(\r?\n                "Transaksi berhasil disimpan\."\r?\n            \)\r?\n            st\.rerun\(\)',
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

$content = [regex]::Replace(
    $content,
    '(?ms)^            csv_rekap = \(\r?\n                rekap\.to_csv\(index=False\)\r?\n                \.encode\("utf-8-sig"\)\r?\n            \)\r?\n\r?\n            st\.download_button\(',
@'
            csv_rekap = (
                rekap.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.info("Klik tombol unduh untuk menyimpan rekap bulanan sebagai CSV.")

            st.download_button(
'@
)

$content = [regex]::Replace(
    $content,
    '(?ms)^            csv = \(\r?\n                df_filter\.to_csv\(index=False\)\r?\n                \.encode\("utf-8-sig"\)\r?\n            \)\r?\n\r?\n            st\.download_button\(',
@'
            csv = (
                df_filter.to_csv(index=False)
                .encode("utf-8-sig")
            )

            st.info("Klik tombol unduh untuk menyimpan riwayat transaksi sebagai CSV.")

            st.download_button(
'@
)

$content = [regex]::Replace(
    $content,
    '(?ms)^            if simpan_perubahan:\r?\n                ubah_transaksi\(\r?\n                    transaction_id,\r?\n                    tanggal_baru,\r?\n                    jenis_baru,\r?\n                    kategori_baru,\r?\n                    nominal_baru,\r?\n                    keterangan_baru,\r?\n                \)\r?\n\r?\n                st\.success\(\r?\n                    "Transaksi berhasil diperbarui\."\r?\n                \)\r?\n                st\.rerun\(\)',
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

$content = [regex]::Replace(
    $content,
    '(?ms)^            if st\.button\(\r?\n                "Hapus Transaksi",\r?\n                disabled=not konfirmasi,\r?\n                use_container_width=True,\r?\n                type="secondary",\r?\n            \):\r?\n                hapus_transaksi\(\r?\n                    transaction_id\r?\n                \)\r?\n                st\.success\(\r?\n                    "Transaksi berhasil dihapus\."\r?\n                \)\r?\n                st\.rerun\(\)',
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
