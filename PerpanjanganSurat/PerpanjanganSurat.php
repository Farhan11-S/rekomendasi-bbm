<?php

/**
 * Class Auth untuk melakukan login dan registrasi user baru
 */
class PerpanjanganSurat
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
        }
        return $suratRekomendasi;
    }

    public function fetchAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM surat_rekomendasi RIGHT JOIN perpanjangan_surat ON surat_rekomendasi.id = perpanjangan_surat.surat_rekomendasi_id");
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

    public function updateStatus($id, $status, $note, $updated_by, $suratRekomendasiID)
    {
        try {
            $stmt = $this->db->prepare("UPDATE perpanjangan_surat SET status=:status, note=:note, updated_by=:updated_by WHERE id=:id");
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":note", $note);
            $stmt->bindParam(":updated_by", $updated_by);
            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if ($status == 'Aktif') {
                $stmt = $this->db->prepare("UPDATE pengajuan_surat SET status=:status WHERE surat_rekomendasi_id=:surat_rekomendasi_id");
                $stmt->bindParam(":status", $status);
                $stmt->bindParam(":surat_rekomendasi_id", $suratRekomendasiID);

                $stmt->execute();
            }
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
            $suratRekomendasi = $this->fetchByIDInput($data['id_input']);
            if (empty($suratRekomendasi)) return false;
            $stmt = $this->db->prepare("INSERT INTO perpanjangan_surat (surat_rekomendasi_id, foto_keterangan, status) VALUES (:surat_rekomendasi_id, :foto_keterangan, 'Menunggu Konfirmasi');");
            $stmt->bindParam(":surat_rekomendasi_id", $suratRekomendasi['id']);
            $stmt->bindParam(":foto_keterangan", $data['foto_keterangan']);

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
