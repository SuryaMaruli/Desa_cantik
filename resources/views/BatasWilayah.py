# =========================================================
# VISUALISASI BATAS WILAYAH KELURAHAN CITANGKIL
# =========================================================

import os
import json
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
geojson_output = r"D:\CPNS\Penugasan\Desa_cantik\storage\app\shapefile\citangkil_boundaries.geojson"

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
    "CITANGKIL",
    "RAMANUJU",
    "MASIGIT",
    "TAMAN BARU",
    "KEBONSARI"
]

# =========================================================
# FILTER DATA
# =========================================================
filtered = gdf[
    (gdf["DESA"].isin(wilayah_dicari)) &
    (gdf["KAB_KOTA"].str.contains("CILEGON", case=False, na=False))
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
    "CITANGKIL": "red",
    "RAMANUJU": "blue",
    "MASIGIT": "green",
    "TAMAN BARU": "orange",
    "KEBONSARI": "purple"
}

# =========================================================
# KETERANGAN BATAS
# =========================================================
keterangan_batas = {
    "RAMANUJU": "Utara",
    "MASIGIT": "Timur",
    "TAMAN BARU": "Selatan",
    "KEBONSARI": "Barat"
}

# =========================================================
# TAMBAHKAN POLYGON
# =========================================================
for _, row in filtered.iterrows():

    nama = row["DESA"]

    color = warna.get(nama, "gray")

    # Tooltip
    if nama == "CITANGKIL":

        tooltip_text = f"""
        <b>{nama}</b><br>
        Kecamatan : {row['KECAMATAN']}<br>
        Kota/Kab  : {row['KAB_KOTA']}
        """

    else:

        arah = keterangan_batas.get(nama, "-")

        tooltip_text = f"""
        <b>{nama}</b><br>
        Batas Sebelah : {arah}<br>
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
        popup=nama,
        tooltip=nama,
        icon=folium.Icon(
            color=warna.get(nama, "gray")
        )
    ).add_to(m)

# =========================================================
# GARIS HUBUNGAN
# =========================================================
citangkil_data = filtered[
    filtered["DESA"] == "CITANGKIL"
]

if not citangkil_data.empty:

    citangkil_geom = citangkil_data.geometry.iloc[0]

    citangkil_centroid = citangkil_geom.centroid

    for _, row in filtered.iterrows():

        nama = row["DESA"]

        if nama != "CITANGKIL":

            target_centroid = row.geometry.centroid

            arah = keterangan_batas.get(nama, "")

            folium.PolyLine(
                locations=[
                    [citangkil_centroid.y, citangkil_centroid.x],
                    [target_centroid.y, target_centroid.x]
                ],
                color=warna.get(nama, "gray"),
                weight=3,
                tooltip=f"Batas {arah}: {nama}"
            ).add_to(m)

# =========================================================
# LAYER CONTROL
# =========================================================
folium.LayerControl().add_to(m)

# =========================================================
# SIMPAN PETA HTML
# =========================================================