<?php

/**
 * Class Auth untuk melakukan login dan registrasi user baru
 */
class Auth
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

        // Mulai session
        session_status() === PHP_SESSION_ACTIVE ?: session_start();
    }

    /**
     * @param $nama
     * @param $password
     * @return bool
     *
     * fungsi login user
     */
    public function login($nama, $password)
    {
        try {
            // Ambil data dari database
            $stmt = $this->db->prepare("SELECT * FROM admin WHERE nama = :nama");
            $stmt->bindParam(":nama", $nama);
            $stmt->execute();
            $data = $stmt->fetch();

            // Jika jumlah baris > 0
            if ($stmt->rowCount() > 0) {
                // jika password yang dimasukkan sesuai dengan yg ada di database
                if (password_verify($password, $data['password'])) {
                    $_SESSION['user_session'] = $data['id'];

                    return true;
                } else {
                    $this->error = "Email atau Password Salah";

                    return false;
                }
            } else {
                $this->error = "Email atau Password Salah";

                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }

    /**
     * @return true|void
     *
     * fungsi cek login user
     */
    public function isLoggedIn()
    {
        // Apakah user_session sudah ada di session

        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    /**
     * @return false
     *
     * fungsi ambil data user yang sudah login
     */
    public function getUser()
    {
        // Cek apakah sudah login
        if (!$this->isLoggedIn()) {
            return false;
        }

        try {
            // Ambil data user dari database
            $stmt = $this->db->prepare("SELECT * FROM admin WHERE id = :id");
            $stmt->bindParam(":id", $_SESSION['user_session']);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();

            return false;
        }
    }

    /**
     * @return true
     *
     * fungsi Logout user
     */
    public function logout()
    {
        // Hapus session
        session_destroy();
        // Hapus user_session
        unset($_SESSION['user_session']);

        return true;
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
