<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ai_assistant extends CI_Model
{
    protected $table = 'ai_assistant_log';

    public function __construct()
    {
        parent::__construct();
    }

    public function ensure_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `userid` VARCHAR(50) NULL,
            `type` ENUM('chat','extract','vision') NOT NULL DEFAULT 'chat',
            `source_filename` VARCHAR(255) NULL,
            `provider` VARCHAR(20) NULL COMMENT 'groq',
            `prompt` MEDIUMTEXT NULL,
            `response` MEDIUMTEXT NULL,
            `created_at` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->db->query($sql);
    }

    public function log($userid, $type, $source_filename, $provider, $prompt, $response)
    {
        $this->ensure_table();
        $this->db->insert($this->table, array(
            'userid'          => $userid,
            'type'            => $type,
            'source_filename' => $source_filename,
            'provider'        => $provider,
            'prompt'          => is_string($prompt) ? $prompt : json_encode($prompt),
            'response'        => is_string($response) ? $response : json_encode($response),
            'created_at'      => date('Y-m-d H:i:s'),
        ));
        return $this->db->insert_id();
    }

    public function history($userid, $limit = 20)
    {
        $this->ensure_table();
        return $this->db->where('userid', $userid)
            ->order_by('id', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result_array();
    }
}
