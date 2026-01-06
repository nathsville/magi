import os
import glob
import pandas as pd

# Path ke folder data WHO
# Pastikan path ini sesuai dengan lokasi file xlsx Anda
folder_path = 'storage/app/who_standards/'

# Cari semua file .xlsx
xlsx_files = glob.glob(os.path.join(folder_path, "*.xlsx"))

print(f"🔍 Ditemukan {len(xlsx_files)} file XLSX. Memulai konversi...")

count = 0
for file in xlsx_files:
    try:
        # Baca Excel
        df = pd.read_excel(file)
        
        # Buat nama file baru dengan akhiran .csv
        csv_filename = file.replace('.xlsx', '.csv')
        
        # Simpan sebagai CSV
        df.to_csv(csv_filename, index=False)
        
        print(f"✅ Berhasil: {os.path.basename(file)} -> {os.path.basename(csv_filename)}")
        count += 1
        
        # Opsional: Hapus file xlsx agar folder bersih (uncomment jika yakin)
        # os.remove(file) 
        
    except Exception as e:
        print(f"❌ Gagal mengonversi {os.path.basename(file)}: {str(e)}")

print(f"\n🎉 Selesai! {count} file berhasil dikonversi ke CSV.")