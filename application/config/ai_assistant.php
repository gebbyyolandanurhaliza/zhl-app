<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['ai_groq_api_key'] = getenv('GROQ_API_KEY') ?: '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';

$config['ai_groq_endpoint'] = 'https://api.groq.com/openai/v1/chat/completions';

$config['ai_groq_chat_model']   = 'openai/gpt-oss-20b';
$config['ai_groq_vision_model'] = 'qwen/qwen3.6-27b';

$config['ai_groq_reasoning_effort']        = 'low';   
$config['ai_groq_vision_reasoning_effort'] = 'none';  

$config['ai_upload_path']      = APPPATH . '../uploads/ai_assistant_tmp/';
$config['ai_allowed_types']    = 'pdf|zip|jpg|jpeg|png|webp';
$config['ai_max_upload_kb']    = 15360; 
$config['ai_max_files_in_zip'] = 20;
