# =========================================================
# VISUALISASI BATAS WILAYAH KELURAHAN GUNUNG SUGIH
# =========================================================

import os
import json
import shutil
import geopandas as gpd
import folium

# =========================================================
# OPTIONAL
# =========================================================
os.environ["SHAPE_RESTORE_SHX"] = "YES"

# =========================================================
# PATH SHAPEFILE
# =========================================================
shp_path = r"D:\CPNS\Penugasan\Desa_cantik\resources\views\BATAS_DESA_DESEMBER_2019_DUKCAPIL_BANTEN.shp"

# =========================================================
# PATH OUTPUT GEOJSON (LARAVEL STORAGE)
# =========================================================
geojson_output = r"D:\CPNS\Penugasan\Desa_cantik\storage\app\shapefile\bulakan_boundaries.geojson"
public_geojson_output = r"D:\CPNS\Penugasan\Desa_cantik\public\shapefile\bulakan_boundaries.geojson"
html_output = r"D:\CPNS\Penugasan\Desa_cantik\resources\views\peta_batas_wilayah_bulakan.html"

# =========================================================
# BACA SHAPEFILE
# =========================================================
print("================================")
print("MEMBACA SHAPEFILE")
print("================================")

gdf = gpd.read_file(shp_path, engine="fiona")

print("Shapefile berhasil dibaca")

# =========================================================
# CRS
# =========================================================
if gdf.crs is None:

    print("\nCRS tidak ditemukan")
    print("Menggunakan EPSG:4326")

    gdf = gdf.set_crs(epsg=4326)

# =========================================================
# HILANGKAN DIMENSI Z
# =========================================================
gdf["geometry"] = gdf.geometry.force_2d()

# =========================================================
# KONVERSI CRS
# =========================================================
gdf = gdf.to_crs(epsg=4326)

# =========================================================
# DAFTAR WILAYAH
# =========================================================
wilayah_dicari = [
    "GUNUNG SUGIH",
    "ANYAR",
    "KOSAMBIRONYOK",
    "KEPUH"
]

# =========================================================
# FILTER DATA
# =========================================================
filtered = gdf[
    (
        (gdf["DESA"].eq("GUNUNG SUGIH") & gdf["KECAMATAN"].str.contains("CIWANDAN", case=False, na=False) & gdf["KAB_KOTA"].str.contains("CILEGON", case=False, na=False)) |
        (gdf["DESA"].eq("ANYAR") & gdf["KECAMATAN"].str.contains("ANYAR", case=False, na=False) & gdf["KAB_KOTA"].str.contains("SERANG", case=False, na=False)) |
        (gdf["DESA"].eq("KOSAMBIRONYOK") & gdf["KECAMATAN"].str.contains("ANYAR", case=False, na=False) & gdf["KAB_KOTA"].str.contains("SERANG", case=False, na=False)) |
        (gdf["DESA"].eq("KEPUH") & gdf["KECAMATAN"].str.contains("CIWANDAN", case=False, na=False) & gdf["KAB_KOTA"].str.contains("CILEGON", case=False, na=False))
    )
].copy()

# =========================================================
# HASIL FILTER
# =========================================================
print("\n================================")
print("HASIL FILTER")
print("================================")

print(filtered[["DESA", "KECAMATAN", "KAB_KOTA"]])

# =========================================================
# VALIDASI
# =========================================================
if filtered.empty:
    raise Exception("Data wilayah tidak ditemukan")

filtered.loc[filtered["DESA"] == "KEPUH", "DESA"] = "KARANGASEM"

# =========================================================
# SIMPAN GEOJSON UNTUK LARAVEL FRONTEND
# =========================================================
print("\n================================")
print("MENYIMPAN GEOJSON")
print("================================")

# Konversi ke GeoJSON
geojson_dict = json.loads(filtered.to_json())

# Buat direktori jika belum ada
os.makedirs(os.path.dirname(geojson_output), exist_ok=True)

with open(geojson_output, 'w') as f:
    json.dump(geojson_dict, f)

print(f"GeoJSON berhasil disimpan: {geojson_output}")

os.makedirs(os.path.dirname(public_geojson_output), exist_ok=True)
shutil.copyfile(geojson_output, public_geojson_output)

print(f"GeoJSON publik berhasil disimpan: {public_geojson_output}")

# =========================================================
# TITIK TENGAH PETA
# =========================================================
center_geom = filtered.union_all().centroid

center_lat = center_geom.y
center_lon = center_geom.x

# =========================================================
# BUAT PETA
# =========================================================
m = folium.Map(
    location=[center_lat, center_lon],
    zoom_start=13,
    tiles="OpenStreetMap"
)

# =========================================================
# WARNA
# =========================================================
warna = {
    "GUNUNG SUGIH": "red",
    "ANYAR": "purple",
    "KOSAMBIRONYOK": "orange",
    "KARANGASEM": "green"
}

# =========================================================
# KETERANGAN BATAS
# =========================================================
keterangan_batas = {
    "ANYAR": "Barat: Berbatasan dengan Desa Anyar di wilayah Kabupaten Serang.",
    "KOSAMBIRONYOK": "Selatan: Berbatasan dengan Desa Kosambi dan Ronyok di wilayah Kabupaten Serang.",
    "KARANGASEM": "Timur: Berbatasan dengan Kelurahan Karangasem."
}

nama_tampil = {
    "GUNUNG SUGIH": "Kelurahan Gunung Sugih",
    "ANYAR": "Desa Anyar",
    "KOSAMBIRONYOK": "Desa Kosambi dan Ronyok",
    "KARANGASEM": "Kelurahan Karangasem"
}

# =========================================================
# TAMBAHKAN POLYGON
# =========================================================
for _, row in filtered.iterrows():

    nama = row["DESA"]

    color = warna.get(nama, "gray")

    # Tooltip
    display_nama = nama_tampil.get(nama, nama)

    if nama == "GUNUNG SUGIH":

        tooltip_text = f"""
        <b>{display_nama}</b><br>
        Kecamatan : {row['KECAMATAN']}<br>
        Kota/Kab  : {row['KAB_KOTA']}
        """

    else:

        batas = keterangan_batas.get(nama, "-")

        tooltip_text = f"""
        <b>{display_nama}</b><br>
        {batas}<br>
        Kecamatan : {row['KECAMATAN']}<br>
        Kota/Kab  : {row['KAB_KOTA']}
        """

    folium.GeoJson(
        row["geometry"],
        style_function=lambda x, color=color: {
            "fillColor": color,
            "color": color,
            "weight": 2,
            "fillOpacity": 0.35
        },
        tooltip=folium.Tooltip(tooltip_text)
    ).add_to(m)

# =========================================================
# TAMBAHKAN MARKER
# =========================================================
for _, row in filtered.iterrows():

    centroid = row.geometry.centroid

    nama = row["DESA"]

    folium.Marker(
        location=[centroid.y, centroid.x],
        popup=nama_tampil.get(nama, nama),
        tooltip=nama_tampil.get(nama, nama),
        icon=folium.Icon(
            color=warna.get(nama, "gray")
        )
    ).add_to(m)

# =========================================================
# GARIS HUBUNGAN
# =========================================================
gunung_sugih_data = filtered[
    filtered["DESA"] == "GUNUNG SUGIH"
]

if not gunung_sugih_data.empty:

    gunung_sugih_geom = gunung_sugih_data.geometry.iloc[0]

    gunung_sugih_centroid = gunung_sugih_geom.centroid

    for _, row in filtered.iterrows():

        nama = row["DESA"]

        if nama != "GUNUNG SUGIH":

            target_centroid = row.geometry.centroid

            batas = keterangan_batas.get(nama, "")

            folium.PolyLine(
                locations=[
                    [gunung_sugih_centroid.y, gunung_sugih_centroid.x],
                    [target_centroid.y, target_centroid.x]
                ],
                color=warna.get(nama, "gray"),
                weight=3,
                tooltip=batas
            ).add_to(m)

    north_point = [
        gunung_sugih_geom.bounds[3] + 0.01,
        gunung_sugih_centroid.x
    ]

    folium.PolyLine(
        locations=[
            [gunung_sugih_centroid.y, gunung_sugih_centroid.x],
            north_point
        ],
        color="blue",
        weight=3,
        dash_array="8, 8",
        tooltip="Utara: Berbatasan langsung dengan Perairan Selat Sunda."
    ).add_to(m)

    folium.Marker(
        location=north_point,
        popup="Perairan Selat Sunda",
        tooltip="Utara: Perairan Selat Sunda",
        icon=folium.Icon(color="blue", icon="info-sign")
    ).add_to(m)

# =========================================================
# LAYER CONTROL
# =========================================================
folium.LayerControl().add_to(m)

os.makedirs(os.path.dirname(html_output), exist_ok=True)
m.save(html_output)
print(f"Peta HTML berhasil disimpan: {html_output}")

# =========================================================
# SIMPAN PETA HTML
# =========================================================



