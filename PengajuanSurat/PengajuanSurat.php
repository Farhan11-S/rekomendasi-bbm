<?php

/**
 * Class Auth untuk melakukan login dan registrasi user baru
 */
class PengajuanSurat
{
    /**
     * @var
     * Menyimpan Koneksi database
     */
    private $db;

    /**
     * @var
     * Menyimpan Error Message
     */
    private $error;

    /**
     * @param $db_conn
     * Contructor untuk class Auth, membutuhkan satu parameter yaitu koneksi ke database
     */
    public function __construct($db_conn)
    {
        $this->db = $db_conn;
    }

    /**
     * @return false
     *
     * fungsi ambil data user yang sudah login
     */
    public function generateID()
    {
        try {
            // Ambil data user dari database
            $stmt = $this->db->prepare("SELECT COUNT(id) AS count_id FROM surat_rekomendasi WHERE DATE(created_at) = CURDATE();");
            $stmt->execute();
            $countID = $stmt->fetch()['count_id'];

            $t = time();
            $formattedTime = date("YmdHis", $t);

            $id = $formattedTime . str_pad($countID + 1, 4, '0', STR_PAD_LEFT);;
            return $id;
        } catch (PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }

    public function fetchByIDInput($id_input)
    {
        $stmt = $this->db->prepare("SELECT * FROM surat_rekomendasi WHERE id_input = ? LIMIT 1");
        $stmt->execute([$id_input]);
        $suratRekomendasi = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($suratRekomendasi) {
            $stmt2 = $this->db->prepare("SELECT * FROM pengajuan_surat WHERE surat_rekomendasi_id = ? LIMIT 1");
            $stmt2->execute([$suratRekomendasi['id']]);

            $suratRekomendasi['pengajuan_surat'] = $stmt2->fetch(PDO::FETCH_ASSOC);

            $stmt3 = $this->db->prepare("SELECT * FROM perpanjangan_surat WHERE surat_rekomendasi_id = ? AND status = 'MENUNGGU KONFIRMASI'  LIMIT 1");
            $stmt3->execute([$suratRekomendasi['id']]);

            $stmt3Result = $stmt3->fetch(PDO::FETCH_ASSOC);
            if ((bool) $stmt3Result) {
                $suratRekomendasi['pengajuan_surat'] = $stmt3Result;
            }
        }
        return $suratRekomendasi;
    }

    public function fetchAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM surat_rekomendasi LEFT JOIN pengajuan_surat ON surat_rekomendasi.id = pengajuan_surat.surat_rekomendasi_id");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetchAllValidasi()
    {
        $stmt = $this->db->prepare("SELECT * FROM surat_rekomendasi LEFT JOIN pengajuan_surat ON surat_rekomendasi.id = pengajuan_surat.surat_rekomendasi_id WHERE status='Menunggu Validasi Kepala Dinas'");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchAllJenisUsaha()
    {
        $stmt = $this->db->prepare("SELECT * FROM jenis_usaha");
        $stmt->execute();
        $result['jenis_alat'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result['jenis_usaha'] = array_unique(array_column($result['jenis_alat'], 'jenis_usaha'));

        return $result;
    }

    public function fetchJenisUsahaByID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM jenis_usaha WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function updateStatus($id, $status, $note, $updated_by)
    {
        try {
            $stmt = $this->db->prepare("UPDATE pengajuan_surat SET status=:status, note=:note, updated_by=:updated_by WHERE id=:id");
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":note", $note);
            $stmt->bindParam(":updated_by", $updated_by);
            $stmt->bindParam(":id", $id);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Jika terjadi error

            if ($e->errorInfo[0] == 23000) {
                //errorInfor[0] berisi informasi error tentang query sql yg baru dijalankan
                //23000 adalah kode error ketika ada data yg sama pada kolom yg di set unique
                $this->error = "Pengiriman gagal!";
                echo $e->getMessage();

                return false;
            } else {
                echo $e->getMessage();

                die();
                return false;
            }
        }
    }

    public function store($data)
    {
        try {

            $stmt = $this->db->prepare("INSERT INTO surat_rekomendasi (id_input, nik, nama_lengkap, alamat, no_hp, jenis_bbm, volume_bbm_harian, jenis_usaha_id, nama_usaha, nomor_induk_spbu, alamat_spbu, nomor_rangka_mesin, foto_mesin, foto_ktp, foto_domisili, merk, tipe) VALUES(:id_input, :nik, :nama_lengkap, :alamat, :no_hp, :jenis_bbm, :volume_bbm_harian, :jenis_usaha_id, :nama_usaha, :nomor_induk_spbu, :alamat_spbu, :nomor_rangka_mesin, :foto_mesin, :foto_ktp, :foto_domisili, :merk, :tipe);");
            $stmt->bindParam(":id_input", $data['id_input']);
            $stmt->bindParam(":nik", $data['nik']);
            $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
            $stmt->bindParam(":alamat", $data['alamat']);
            $stmt->bindParam(":no_hp", $data['no_hp']);
            $stmt->bindParam(":jenis_bbm", $data['jenis_bbm']);
            $stmt->bindParam(":volume_bbm_harian", $data['volume_bbm_harian']);
            $stmt->bindParam(":jenis_usaha_id", $data['jenis_usaha_id']);
            $stmt->bindParam(":nama_usaha", $data['nama_usaha']);
            $stmt->bindParam(":nomor_induk_spbu", $data['nomor_induk_spbu']);
            $stmt->bindParam(":alamat_spbu", $data['alamat_spbu']);
            $stmt->bindParam(":nomor_rangka_mesin", $data['nomor_rangka_mesin']);
            $stmt->bindParam(":foto_mesin", $data['foto_mesin']);
            $stmt->bindParam(":foto_ktp", $data['foto_ktp']);
            $stmt->bindParam(":foto_domisili", $data['foto_domisili']);
            $stmt->bindParam(":merk", $data['merk']);
            $stmt->bindParam(":tipe", $data['tipe']);

            $stmt->execute();
            $surat_rekomendasi_id = $this->db->lastInsertId();

            $stmt2 = $this->db->prepare("INSERT INTO pengajuan_surat (surat_rekomendasi_id, status) VALUES(:surat_rekomendasi_id, 'Menunggu Konfirmasi');");
            $stmt2->bindParam(":surat_rekomendasi_id", $surat_rekomendasi_id);

            $stmt2->execute();

            return true;
        } catch (PDOException $e) {
            // Jika terjadi error

            if ($e->errorInfo[0] == 23000) {
                //errorInfor[0] berisi informasi error tentang query sql yg baru dijalankan
                //23000 adalah kode error ketika ada data yg sama pada kolom yg di set unique
                $this->error = "Pengiriman gagal!";
                echo $e->getMessage();

                return false;
            } else {
                echo $e->getMessage();

                return false;
            }
        }
    }

    /**
     * @return mixed
     *
     * fungsi ambil error terakhir yg disimpan di variable error
     */
    public function getLastError()
    {
        return $this->error;
    }
}