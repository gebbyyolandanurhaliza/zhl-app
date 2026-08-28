<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_saldo_awal_zht extends CI_Model
{
    public function save_saldo($data) {
        $this->db->where('nocoa', $data['nocoa']);
        $query = $this->db->get('zht_acc_tbl_trn_saldoawal');
        
        if ($query->num_rows() > 0) {
            // Update jika data sudah ada
            $this->db->where('nocoa', $data['nocoa']);
            return $this->db->update('zht_acc_tbl_trn_saldoawal', $data);
        } else {
            // Insert jika data belum ada
            return $this->db->insert('zht_acc_tbl_trn_saldoawal', $data);
        }
    }

    public function getAllSaldo()
    {
        $this->db->select('*');
        $this->db->from('zht_acc_tbl_trn_saldoawal'); // Ganti 'your_table' dengan nama tabel yang sesuai
        $query = $this->db->get();
        return $query->result(); // Mengembalikan data sebagai array of objects
    }

    public function search_saldo($searchTerm) {
        $this->db->like('nocoa', $searchTerm); // Search by COA Number
        $this->db->or_like('periode_bulan', $searchTerm); // Or search by Periode Bulan
        return $this->db->get('zht_acc_tbl_trn_saldoawal')->result(); // Assuming 'saldo_awal' is the table name
    }

    public function delete_saldo($nocoa) {
        $this->db->where('nocoa', $nocoa); // Filter by COA Number
        $this->db->delete('zht_acc_tbl_trn_saldoawal'); // Delete the record
    }
    
    public function get_saldo_by_nocoa($nocoa) {
        $query = $this->db->get_where('zht_acc_tbl_trn_saldoawal', ['nocoa' => $nocoa]);
        return $query->row(); // Return a single record
    }
    
    public function update_saldo($nocoa, $data)
{
    $this->db->where('nocoa', $data['nocoa']);
        $query = $this->db->get('zht_acc_tbl_trn_saldoawal');
        
        if ($query->num_rows() > 0) {
            // Update jika data sudah ada
            $this->db->where('nocoa', $data['nocoa']);
            return $this->db->update('zht_acc_tbl_trn_saldoawal', $data);
        } else {
            // Insert jika data belum ada
            return $this->db->insert('zht_acc_tbl_trn_saldoawal', $data);
        }
}

}
