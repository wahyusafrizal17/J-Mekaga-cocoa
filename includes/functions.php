<?php
/**
 * Frontend Helper Functions
 * Mega Kayan Ganesha
 */

require_once __DIR__ . '/../config/database.php';

// Get all published articles
function getArticles($limit = null, $kategori = null) {
    $db = getDB();
    $sql = "SELECT * FROM artikel WHERE status = 'published'";
    $params = [];
    
    if ($kategori) {
        $sql .= " AND kategori = ?";
        $params[] = $kategori;
    }
    
    $sql .= " ORDER BY published_at DESC, created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Get single article by slug
function getArticleBySlug($slug) {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM artikel WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// Get all published journals
function getJournals($limit = null, $kategori = null) {
    $db = getDB();
    $sql = "SELECT * FROM jurnal WHERE status = 'published'";
    $params = [];
    
    if ($kategori) {
        $sql .= " AND kategori = ?";
        $params[] = $kategori;
    }
    
    $sql .= " ORDER BY published_at DESC, created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Get all published CSR
function getCSR($limit = null, $kategori = null) {
    $db = getDB();
    $sql = "SELECT * FROM csr WHERE status = 'published'";
    $params = [];
    
    if ($kategori) {
        $sql .= " AND kategori = ?";
        $params[] = $kategori;
    }
    
    $sql .= " ORDER BY published_at DESC, created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Get open job vacancies
function getLowongan($limit = null, $divisi = null) {
    $db = getDB();
    $sql = "SELECT * FROM lowongan WHERE status = 'open'";
    $params = [];
    
    if ($divisi) {
        $sql .= " AND divisi = ?";
        $params[] = $divisi;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Get approved testimonials
function getTestimonials($limit = null, $kategori = null) {
    $db = getDB();
    $sql = "SELECT * FROM testimoni WHERE status = 'approved'";
    $params = [];
    
    if ($kategori) {
        $sql .= " AND kategori = ?";
        $params[] = $kategori;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    if ($limit) {
        $sql .= " LIMIT ?";
        $params[] = $limit;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Get setting value
function getSetting($key, $default = '') {
    $db = getDB();
    $stmt = $db->prepare("SELECT value FROM settings WHERE `key` = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetch();
    return $result ? $result['value'] : $default;
}

// Format date Indonesian
function formatDateID($date, $format = 'd F Y') {
    if (empty($date)) return '-';
    
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = $bulan[(int)date('m', $timestamp)];
    $year = date('Y', $timestamp);
    
    return "$day $month $year";
}

// Truncate text
function truncate($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

