# 📊 Analisis Mendalam Model Machine Learning SARIMA

Dokumen ini menjelaskan detail teknis, rumus matematika, dan logika pengolahan data pada sistem prediksi kunjungan wisata Bunihayu menggunakan algoritma **SARIMA** (*Seasonal Autoregressive Integrated Moving Average*).

---

## 1. Rumus Matematika SARIMA

Model yang digunakan adalah **SARIMA(p, d, q)(P, D, Q)s**. Model ini merupakan pengembangan dari ARIMA yang menambahkan komponen musiman (*seasonality*).

### Rumus Umum:
$$\Phi_P(L^s) \phi_p(L) (1-L)^d (1-L^s)^D Y_t = \Theta_Q(L^s) \theta_q(L) \epsilon_t$$

**Keterangan Parameter:**
-   **$(p, d, q)$**: Komponen Non-Musiman.
    -   $p$ (Autoregressive): Hubungan antara data sekarang dengan data sebelumnya.
    -   $d$ (Integrated): Berapa kali data harus di-selisih (*differencing*) agar stasioner.
    -   $q$ (Moving Average): Hubungan antara data sekarang dengan error sebelumnya.
-   **$(P, D, Q)_s$**: Komponen Musiman.
    -   $s$ (Seasonality): Periode musiman (dalam project ini **$s=12$** untuk pola bulanan).
-   **$L$**: Lag operator.
-   **$\epsilon_t$**: White noise (error).

---

## 2. Metrik Evaluasi (Akurasi)

Akurasi model dihitung menggunakan tiga metrik utama yang umum digunakan dalam skripsi/penelitian *forecasting*:

1.  **Mean Absolute Error (MAE)**:
    $$MAE = \frac{1}{n} \sum_{i=1}^{n} |y_i - \hat{y}_i|$$
    *Interpretasi: Rata-rata kesalahan absolut jumlah pengunjung.*

2.  **Root Mean Square Error (RMSE)**:
    $$RMSE = \sqrt{\frac{1}{n} \sum_{i=1}^{n} (y_i - \hat{y}_i)^2}$$
    *Interpretasi: Memberikan bobot lebih besar pada error yang besar (penalti untuk outlier).*

3.  **Mean Absolute Percentage Error (MAPE)**:
    $$MAPE = \frac{100\%}{n} \sum_{i=1}^{n} \left| \frac{y_i - \hat{y}_i}{y_i} \right|$$
    *Interpretasi: Persentase error rata-rata. MAPE < 10% dikategorikan "Sangat Baik".*

---

## 3. Logika Preprocessing & Best Practice

Berdasarkan analisis file `preprocessing.py` dan `sarima_model.py`, berikut adalah tahapan cerdas yang dilakukan sistem:

### A. Penanganan Data Kosong (Imputasi)
-   **Forward Fill**: Menangani sel kosong akibat *merged cells* di Excel pada kolom Tahun dan Bulan.
-   **Linear Interpolation**: Mengisi data bulan Maret/Ramadan yang biasanya kosong atau rendah drastis menggunakan rata-rata bulan sebelumnya dan sesudahnya agar deret waktu tetap kontinu.

### B. Uji Stasioneritas (ADF Test)
Sistem menjalankan **Augmented Dickey-Fuller (ADF) Test**.
-   **H0**: Data tidak stasioner.
-   **H1**: Data stasioner.
-   Jika p-value < 0.05, data dianggap stasioner dan siap diproses. Jika tidak, sistem melakukan *differencing* ($d$).

### C. Pemilihan Parameter Otomatis (Auto SARIMA)
Sistem menggunakan library `pmdarima` dengan metode **Stepwise Search** untuk mencari kombinasi $(p,d,q)(P,D,Q)$ yang menghasilkan nilai **AIC (Akaike Information Criterion)** terkecil. Ini memastikan model selalu optimal meskipun dataset berubah.

---

## 4. Verifikasi Logika Retrain (Update Data)

Sistem telah dirancang untuk **skalabilitas**. Berikut alur saat Admin menambah data:

1.  **Input Baru**: Data masuk ke `Drafting Data Bunihayu Rev.csv`.
2.  **Trigger Retrain**: Admin klik tombol "Retrain" di Dashboard.
3.  **Pipeline Eksekusi**:
    -   API Flask memanggil `run_preprocessing()`: Membersihkan data baru, re-agregasi ke bulanan.
    -   API memanggil `run_sarima_pipeline()`: Mencari ulang parameter optimal (karena tren data mungkin berubah), fitting model baru, dan mengupdate file `predictions.json`.
4.  **Output Baru**: Website Laravel otomatis menampilkan grafik terbaru tanpa perlu restart server.

---

## 5. Catatan untuk Kebutuhan Skripsi

> [!TIP]
> **Mengapa SARIMA dipilih?**
> Karena data kunjungan wisata memiliki pola musiman yang kuat (misal: lonjakan di hari libur/akhir tahun). Model ARIMA biasa tidak bisa menangkap pola ini, sehingga SARIMA adalah pilihan yang paling tepat secara metodologi.

> [!IMPORTANT]
> **Best Practice yang diterapkan:**
> 1. **Train-Test Split (80:20)**: Model dilatih dengan 80% data dan diuji dengan 20% data sisanya untuk validasi akurasi realistik.
> 2. **Confidence Interval (95%)**: Prediksi tidak hanya berupa angka tunggal, tapi juga area batas atas/bawah (95% CI) untuk menunjukkan ketidakpastian.
> 3. **Handling Small Data**: Jika data masih sedikit, sistem secara adaptif menyesuaikan periode musiman agar tidak terjadi error matematika.

---

## Kesimpulan Keandalan
Model saat ini sudah **sangat stabil**.
-   **Anti-Error**: Dilengkapi *fallback* parameter jika Auto SARIMA gagal.
-   **Akurat**: Menggunakan optimasi AIC/BIC.
-   **Dinamis**: Siap menerima ribuan baris data baru di masa depan melalui fitur upload dataset.
