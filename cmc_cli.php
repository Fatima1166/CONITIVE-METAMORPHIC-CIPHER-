<?php
/*
 * COGNITIVE METAMORPHIC CIPHER (CMC) SYSTEM
 * Browser Interface Only
 * UI: Full-screen app shell (sidebar + split workspace)
 */
class CognitiveMetamorphicCipher {
    // Personal developer details (as requested)
    private $developerName = "Fatima,Momina,Iqra";
    private $studentID = "BSET-FALL23-010";
    private $university = "Foundation University";
    private $projectVersion = "2.5"; // Updated version
    private $cognitiveFactors = [];
    private $drift = 0;
    private $weightedDrift = 0;
    private $driftedKey = [];
    private $blockSize = 0;
    private $encryptionHistory = [];
    private $passwordVerificationFile = "cmc_password_verification.enc";
    private $storageKey = "CMC_STORAGE_KEY_2026_FUI"; // Enhanced key
    private $isBrowser = true;

    public function __construct() {
        $this->isBrowser = true; // Always browser mode
    }

    /**
     * Tab metadata used by sidebar + top bar
     */
    private function getTabMeta() {
        return [
            'encrypt' => [
                'icon' => '🔒', 'nav' => 'Encrypt', 'hint' => 'Secure a message',
                'title' => 'Encrypt Message',
                'sub' => 'Transform plaintext into a metamorphic ciphertext'
            ],
            'decrypt' => [
                'icon' => '🔓', 'nav' => 'Decrypt', 'hint' => 'Recover a message',
                'title' => 'Decrypt Message',
                'sub' => 'Verify the password and restore the original text'
            ],
            'explanation' => [
                'icon' => '📖', 'nav' => 'Algorithm', 'hint' => 'How it works',
                'title' => 'Algorithm Explanation',
                'sub' => 'Understand cognitive drift and metamorphic block operations'
            ],
            'tools' => [
                'icon' => '🛠️', 'nav' => 'Tools', 'hint' => 'Maintenance',
                'title' => 'Tools',
                'sub' => 'Manage stored verification data'
            ],
        ];
    }

    /**
     * Sidebar (brand + navigation + team card)
     */
    private function displayBrowserBanner($mode = 'main', $active = 'encrypt') {
        $html = '<aside class="sidebar">';

        $html .= '<div class="brand">';
        $html .= '<svg class="brand-mark" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">'
              .  '<defs><linearGradient id="bm" x1="0" y1="0" x2="48" y2="48"><stop offset="0" stop-color="#2dd4bf"/><stop offset="1" stop-color="#8b5cf6"/></linearGradient></defs>'
              .  '<path d="M24 3 42 13.5v21L24 45 6 34.5v-21L24 3Z" stroke="url(#bm)" stroke-width="2.4" fill="rgba(45,212,191,0.08)"/>'
              .  '<rect x="16" y="21" width="16" height="12" rx="3" fill="url(#bm)"/>'
              .  '<path d="M19 21v-3.5a5 5 0 0 1 10 0V21" stroke="url(#bm)" stroke-width="2.4" stroke-linecap="round"/>'
              .  '<circle cx="24" cy="27" r="1.8" fill="#0b1018"/>'
              .  '</svg>';
        $html .= '<div><div class="brand-name">Cognitive Metamorphic Cipher</div><div class="brand-sub">CMC System</div></div>';
        $html .= '</div>';

        $html .= '<div><div class="nav-label">Workspace</div><nav class="nav">';
        foreach ($this->getTabMeta() as $key => $m) {
            $inner = '<span class="ico">' . $m['icon'] . '</span>'
                   . '<span class="nav-text">' . $m['nav'] . '<small>' . $m['hint'] . '</small></span>';
            if ($mode === 'main') {
                $cls = 'nav-item' . ($key === $active ? ' active' : '');
                $html .= '<button type="button" class="' . $cls . '" data-tab="' . $key . '"'
                       . ' data-title="' . htmlspecialchars($m['title']) . '"'
                       . ' data-sub="' . htmlspecialchars($m['sub']) . '"'
                       . ' onclick="switchTab(\'' . $key . '\')">' . $inner . '</button>';
            } else {
                $html .= '<a class="nav-item" href="?#' . $key . '">' . $inner . '</a>';
            }
        }
        $html .= '</nav></div>';

        $html .= '<div class="team-card">';
        $html .= '<div class="team-title">Professional Encryption &amp; Decryption System</div>';
        $html .= '<div class="team-row"><span>Developers</span><b>' . htmlspecialchars($this->developerName) . '</b></div>';
        $html .= '<div class="team-row"><span>Student ID</span><b>' . htmlspecialchars($this->studentID) . '</b></div>';
        $html .= '<div class="team-row"><span>University</span><b>' . htmlspecialchars($this->university) . '</b></div>';
        $html .= '<div class="team-row"><span>Version</span><b>' . htmlspecialchars($this->projectVersion) . '</b></div>';
        $html .= '</div>';

        $html .= '</aside>';
        return $html;
    }

    /**
     * Convert string to ASCII numeric array
     */
    private function stringToAscii($str) {
        $asciiArray = [];
        for ($i = 0; $i < strlen($str); $i++) {
            $asciiArray[] = ord($str[$i]);
        }
        return $asciiArray;
    }

    /**
     * Convert ASCII numeric array back to string
     */
    private function asciiToString($asciiArray) {
        $str = '';
        foreach ($asciiArray as $value) {
            $str .= chr($value);
        }
        return $str;
    }

    /**
     * Enhanced encryption for storage with stronger algorithm
     */
    private function encryptForStorage($data, $key) {
        $encrypted = '';
        $keyLength = strlen($key);
        for ($i = 0; $i < strlen($data); $i++) {
            $encrypted .= chr((ord($data[$i]) + ord($key[$i % $keyLength]) + $i) % 256);
        }
        return base64_encode($encrypted);
    }

    /**
     * Enhanced decryption for storage
     */
    private function decryptFromStorage($encryptedData, $key) {
        $data = base64_decode($encryptedData);
        $decrypted = '';
        $keyLength = strlen($key);
        for ($i = 0; $i < strlen($data); $i++) {
            $decrypted .= chr((ord($data[$i]) - ord($key[$i % $keyLength]) - $i + 512) % 256);
        }
        return $decrypted;
    }

    /**
     * Parse cognitive behavior factors from comma-separated string
     */
    private function parseCognitiveFactors($factorString, $requiredCount = null) {
        $this->encryptionHistory[] = "=== Parsing Cognitive Factors ===";

        $trimmed = trim($factorString);

        if ($trimmed === "" && $requiredCount === null) {
            $numFactors = rand(3, 8);
            $this->cognitiveFactors = [];
            for ($i = 0; $i < $numFactors; $i++) {
                $this->cognitiveFactors[] = round(rand(0, 100) / 100, 2);
            }
            $this->encryptionHistory[] = "Generated random cognitive factors: " .
                implode(", ", $this->cognitiveFactors);
            return $this->cognitiveFactors;
        }

        $parts = array_values(array_filter(array_map('trim', explode(',', $factorString)), function($v){ return $v !== ''; }));
        
        if ($requiredCount !== null && count($parts) !== $requiredCount) {
            $this->encryptionHistory[] = "Error: Expected exactly $requiredCount cognitive factors, got " . count($parts);
            return false;
        }

        $parsed = [];
        foreach ($parts as $p) {
            if (!is_numeric($p)) {
                $this->encryptionHistory[] = "Error: Non-numeric cognitive factor encountered: '$p'";
                return false;
            }
            $val = floatval($p);
            if ($val < 0) $val = 0;
            if ($val > 1) $val = 1;
            $parsed[] = round($val, 2);
        }

        $this->cognitiveFactors = $parsed;
        $this->encryptionHistory[] = "Cognitive Factors: " . implode(", ", $this->cognitiveFactors);
        return $this->cognitiveFactors;
    }

    /**
     * Calculate drift as average of cognitive factors
     */
    private function calculateDrift() {
        if (empty($this->cognitiveFactors)) {
            $this->drift = 0;
            $this->weightedDrift = 0;
            return 0;
        }
        $sum = array_sum($this->cognitiveFactors);
        $this->drift = $sum / count($this->cognitiveFactors);
        $this->encryptionHistory[] = "Drift Calculation: " . sprintf("%.4f", $this->drift) .
                                     " (average of " . count($this->cognitiveFactors) . " factors)";
        
        $this->calculateWeightedDrift();
        
        return $this->drift;
    }

    /**
     * Calculate weighted drift
     */
    private function calculateWeightedDrift() {
        if (empty($this->cognitiveFactors)) {
            $this->weightedDrift = 0;
            return 0;
        }
        
        $weightedSum = 0;
        $totalWeight = 0;
        
        foreach ($this->cognitiveFactors as $index => $factor) {
            $weight = $factor * $factor;
            $weightedSum += $factor * $weight;
            $totalWeight += $weight;
        }
        
        $this->weightedDrift = $totalWeight > 0 ? $weightedSum / $totalWeight : 0;
        
        $this->encryptionHistory[] = "Weighted Drift: " . sprintf("%.4f", $this->weightedDrift) .
                                     " (emphasizes higher values)";
        
        return $this->weightedDrift;
    }

    /**
     * Generate drifted key from base key and cognitive drift
     */
    private function generateDriftedKey($baseKeyAscii) {
        $this->encryptionHistory[] = "=== Generating Drifted Key ===";
        $this->encryptionHistory[] = "Using Weighted Drift for key generation: " . sprintf("%.4f", $this->weightedDrift);

        if (empty($baseKeyAscii)) {
            $this->driftedKey = [1, 2, 3, 4];
            $this->encryptionHistory[] = "Warning: Empty password! Using default key: [1, 2, 3, 4]";
        } else {
            $this->driftedKey = [];
            foreach ($baseKeyAscii as $index => $keyByte) {
                $drifted = ($keyByte + ($this->weightedDrift * 15)) % 256;
                $this->driftedKey[] = intval($drifted);
            }
        }

        $this->encryptionHistory[] = "Final Drifted Key: [" . implode(", ", $this->driftedKey) . "]";
        return $this->driftedKey;
    }

    /**
     * Divide array into blocks of EXACTLY user-defined size
     */
    private function createBlocks($data, $blockSize) {
        $this->encryptionHistory[] = "Creating blocks with EXACT size: $blockSize";

        $blocks = [];
        $totalElements = count($data);
        $numBlocks = ceil($totalElements / $blockSize);

        for ($i = 0; $i < $numBlocks; $i++) {
            $start = $i * $blockSize;
            $block = array_slice($data, $start, $blockSize);

            if (count($block) < $blockSize && $i == $numBlocks - 1) {
                $padding = $blockSize - count($block);
                $this->encryptionHistory[] = "Padding last block (Block $i) with $padding random bytes";
                for ($j = 0; $j < $padding; $j++) {
                    $block[] = rand(1, 255);
                }
            }

            $blocks[] = $block;
        }

        return $blocks;
    }

    /**
     * Remove padding from decrypted data
     */
    private function removePadding($data) {
        if (empty($data)) {
            return $data;
        }
        
        $lastPrintableIndex = -1;
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i] >= 32 && $data[$i] <= 126) {
                $lastPrintableIndex = $i;
            }
        }
        
        if ($lastPrintableIndex >= 0) {
            return array_slice($data, 0, $lastPrintableIndex + 1);
        }
        
        return [];
    }

    /**
     * Generate verification code from hex string and password (IMPROVED)
     */
    private function generateVerificationCode($hexString, $password) {
        $cleanHex = trim($hexString);
        $cleanPass = trim($password);
        
        $combined = $cleanHex . "||" . $cleanPass . "||" . 
                   sprintf("%.4f", $this->weightedDrift) . "||CMC_v2.5||";
        
        $hash1 = hash('sha256', $combined);
        $hash2 = hash('sha256', $hash1 . $this->storageKey);
        
        return substr($hash2, 0, 32);
    }

    /**
     * Verify if password is correct for given hex string (IMPROVED)
     */
    private function verifyPasswordForHex($hexString, $password) {
        $expectedCode = $this->generateVerificationCode($hexString, $password);
        
        $cleanHex = trim($hexString);
        
        if (file_exists($this->passwordVerificationFile)) {
            $encryptedLines = file($this->passwordVerificationFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (empty($encryptedLines)) {
                $this->encryptionHistory[] = "Warning: Verification file exists but is empty";
                return false;
            }

            foreach ($encryptedLines as $lineNum => $encryptedLine) {
                try {
                    $decryptedLine = $this->decryptFromStorage($encryptedLine, $this->storageKey);
                    
                    if (strpos($decryptedLine, '|') !== false) {
                        $parts = explode('|', $decryptedLine, 2);
                        if (count($parts) == 2) {
                            list($storedHex, $storedCode) = $parts;
                            
                            if (trim($storedHex) === $cleanHex) {
                                $this->encryptionHistory[] = "Hex matched! Verifying code...";
                                return $expectedCode === $storedCode;
                            }
                        }
                    }
                } catch (Exception $e) {
                    $this->encryptionHistory[] = "Error decrypting line $lineNum: " . $e->getMessage();
                    continue;
                }
            }
            
            $this->encryptionHistory[] = "No matching hex found in verification file";
        } else {
            $this->encryptionHistory[] = "Verification file not found: " . $this->passwordVerificationFile;
        }
        
        return false;
    }

    /**
     * Store verification code for hex string and password (IMPROVED)
     */
    private function storeVerificationCode($hexString, $password) {
        $verificationCode = $this->generateVerificationCode($hexString, $password);
        
        $cleanHex = trim($hexString);
        
        $line = $cleanHex . '|' . $verificationCode;
        
        $encryptedLine = $this->encryptForStorage($line, $this->storageKey) . PHP_EOL;

        $result = file_put_contents($this->passwordVerificationFile, $encryptedLine, FILE_APPEND | LOCK_EX);
        
        if ($result === false) {
            $this->encryptionHistory[] = "Error: Could not write to verification file";
        } else {
            $this->encryptionHistory[] = "✓ Verification code stored securely in: " . $this->passwordVerificationFile;
        }
        
        return $verificationCode;
    }

    /**
     * Apply operation based on block index
     */
    private function applyBlockOperation($charValue, $keyValue, $position, $blockIndex) {
        switch ($blockIndex % 3) {
            case 0:
                $result = $charValue ^ $keyValue;
                $this->encryptionHistory[] = "    Operation: XOR ($charValue XOR $keyValue = $result)";
                break;

            case 1:
                $weightedInfluence = intval($this->weightedDrift * 100) % 100;
                $result = ($charValue + $keyValue + $position + $weightedInfluence) % 256;
                $this->encryptionHistory[] = "    Operation: ADD with Weighted Drift ($charValue + $keyValue + $position + $weightedInfluence = $result mod 256)";
                break;

            case 2:
                $result = ($charValue - $keyValue + 256) % 256;
                $this->encryptionHistory[] = "    Operation: SUB ($charValue - $keyValue = $result mod 256)";
                break;
        }

        return $result;
    }

    /**
     * Reverse operation based on block index (for decryption)
     */
    private function reverseBlockOperation($cipherValue, $keyValue, $position, $blockIndex) {
        switch ($blockIndex % 3) {
            case 0:
                $result = $cipherValue ^ $keyValue;
                $this->encryptionHistory[] = "    Operation: Reverse XOR ($cipherValue XOR $keyValue = $result)";
                break;

            case 1:
                $weightedInfluence = intval($this->weightedDrift * 100) % 100;
                $result = ($cipherValue - $keyValue - $position - $weightedInfluence + 512) % 256;
                $this->encryptionHistory[] = "    Operation: Reverse ADD with Weighted Drift ($cipherValue - $keyValue - $position - $weightedInfluence = $result mod 256)";
                break;

            case 2:
                $result = ($cipherValue + $keyValue) % 256;
                $this->encryptionHistory[] = "    Operation: Reverse SUB ($cipherValue + $keyValue = $result)";
                break;
        }

        return $result;
    }

    /**
     * Main encryption method
     */
    public function encrypt($plaintext, $password, $cognitiveFactors, $blockSize) {
        $this->encryptionHistory = [];

        if ($blockSize < 1) {
            return ['error' => 'Block size must be at least 1.'];
        }

        $this->blockSize = $blockSize;

        $cleanPlaintext = trim($plaintext);
        $cleanPassword = trim($password);
        
        $this->encryptionHistory[] = "Plaintext: \"$cleanPlaintext\"";
        $this->encryptionHistory[] = "Password: \"" . ($cleanPassword === "" ? "(empty)" : str_repeat("*", strlen($cleanPassword))) . "\"";
        $this->encryptionHistory[] = "Block Size: $blockSize";

        $plaintextAscii = $this->stringToAscii($cleanPlaintext);
        $keyAscii = $this->stringToAscii($cleanPassword);

        $parsedFactors = $this->parseCognitiveFactors($cognitiveFactors, 3);
        if ($parsedFactors === false) {
            return ['error' => 'Cognitive factors must be exactly 3 comma-separated numbers between 0 and 1.'];
        }
        $this->cognitiveFactors = $parsedFactors;

        $this->calculateDrift();
        $this->generateDriftedKey($keyAscii);

        $blocks = $this->createBlocks($plaintextAscii, $blockSize);
        $this->encryptionHistory[] = "=== Block Division (EXACT Size: $blockSize) ===";
        $this->encryptionHistory[] = "Total ASCII characters: " . count($plaintextAscii);
        $this->encryptionHistory[] = "Number of blocks created: " . count($blocks);

        $this->encryptionHistory[] = "=== Metamorphic Encryption ===";
        $this->encryptionHistory[] = "Weighted Drift Active: " . sprintf("%.4f", $this->weightedDrift);
        
        $cipherAscii = [];
        $currentKey = $this->driftedKey;
        $keyLength = count($currentKey);

        if ($keyLength === 0) {
            $currentKey = [1, 2, 3, 4];
            $keyLength = count($currentKey);
            $this->encryptionHistory[] = "Warning: Empty key detected! Using default key.";
        }

        foreach ($blocks as $blockIndex => $block) {
            $this->encryptionHistory[] = "--- Processing Block $blockIndex ---";

            $operationType = $blockIndex % 3;
            $operationName = ["XOR", "ADDITION with Weighted Drift", "SUBTRACTION"][$operationType];
            $this->encryptionHistory[] = "Operation: $operationName";

            $encryptedBlock = [];
            $blockSum = 0;

            foreach ($block as $charIndex => $charValue) {
                $keyIndex = $charIndex % $keyLength;
                $encryptedChar = $this->applyBlockOperation($charValue, $currentKey[$keyIndex], $charIndex, $blockIndex);
                $encryptedBlock[] = $encryptedChar;
                $blockSum += $encryptedChar;
            }

            $this->encryptionHistory[] = "Block $blockIndex Sum: $blockSum";

            $newKey = [];
            foreach ($currentKey as $keyIndex => $keyValue) {
                $newKeyValue = ($keyValue + $blockSum) % 256;
                $newKey[] = $newKeyValue;
            }

            $currentKey = $newKey;
            $cipherAscii = array_merge($cipherAscii, $encryptedBlock);
        }

        $ciphertext = $this->asciiToString($cipherAscii);
        $hexCiphertext = bin2hex($ciphertext);

        $this->encryptionHistory[] = "=== Final Results ===";
        $this->encryptionHistory[] = "Ciphertext (hex): " . $hexCiphertext;

        // Store verification code
        $verificationCode = $this->storeVerificationCode($hexCiphertext, $cleanPassword);

        $result = [
            'ciphertext' => $ciphertext,
            'hex_string' => $hexCiphertext,
            'history' => $this->encryptionHistory,
            'factors' => $this->cognitiveFactors,
            'drift' => $this->drift,
            'weighted_drift' => $this->weightedDrift,
            'initial_key' => $this->driftedKey,
            'block_size' => $blockSize,
            'num_blocks' => count($blocks),
            'verification_code' => $verificationCode,
            'plaintext' => $cleanPlaintext,
            'password' => $cleanPassword
        ];

        return $result;
    }

    /**
     * Main decryption method - FIXED password verification issue
     */
    public function decrypt($ciphertext, $password, $cognitiveFactors, $blockSize, $hexString = "") {
        $this->encryptionHistory = [];

        if ($blockSize < 1) {
            return ['error' => 'Block size must be at least 1.'];
        }

        $this->blockSize = $blockSize;

        $cleanPassword = trim($password);
        
        if (empty($hexString)) {
            $hexString = bin2hex($ciphertext);
        }
        
        $cleanHexString = trim($hexString);

        $this->encryptionHistory[] = "Ciphertext (hex): $cleanHexString";
        $this->encryptionHistory[] = "Password: \"" . ($cleanPassword === "" ? "(empty)" : str_repeat("*", strlen($cleanPassword))) . "\"";
        $this->encryptionHistory[] = "Block Size: $blockSize";

        // Parse cognitive factors first to get weighted drift
        $parsedFactors = $this->parseCognitiveFactors($cognitiveFactors, 3);
        if ($parsedFactors === false) {
            return ['error' => 'Cognitive factors must be exactly 3 comma-separated numbers between 0 and 1.'];
        }
        $this->cognitiveFactors = $parsedFactors;

        $this->calculateDrift();
        
        // Verify password BEFORE attempting decryption
        $passwordVerified = $this->verifyPasswordForHex($cleanHexString, $cleanPassword);

        if (!$passwordVerified) {
            return ['error' => 'PASSWORD VERIFICATION FAILED! The password you entered does NOT match the encryption password.'];
        }

        $cipherAscii = $this->stringToAscii($ciphertext);
        $keyAscii = $this->stringToAscii($cleanPassword);

        $this->generateDriftedKey($keyAscii);

        $blocks = $this->createBlocks($cipherAscii, $blockSize);
        $this->encryptionHistory[] = "=== Block Division (EXACT Size: $blockSize) ===";

        $this->encryptionHistory[] = "=== Metamorphic Decryption ===";
        $plainAscii = [];
        $currentKey = $this->driftedKey;
        $keyLength = count($currentKey);

        if ($keyLength === 0) {
            $currentKey = [1, 2, 3, 4];
            $keyLength = count($currentKey);
            $this->encryptionHistory[] = "Warning: Empty password detected! Using default key.";
        }

        foreach ($blocks as $blockIndex => $block) {
            $this->encryptionHistory[] = "--- Processing Block $blockIndex ---";

            $decryptedBlock = [];
            $blockSum = 0;

            foreach ($block as $cipherValue) {
                $blockSum += $cipherValue;
            }

            foreach ($block as $charIndex => $cipherValue) {
                $keyIndex = $charIndex % $keyLength;
                $decryptedChar = $this->reverseBlockOperation($cipherValue, $currentKey[$keyIndex], $charIndex, $blockIndex);
                $decryptedBlock[] = $decryptedChar;
            }

            $newKey = [];
            foreach ($currentKey as $keyIndex => $keyValue) {
                $newKeyValue = ($keyValue + $blockSum) % 256;
                $newKey[] = $newKeyValue;
            }

            $currentKey = $newKey;
            $plainAscii = array_merge($plainAscii, $decryptedBlock);
        }

        $plainAscii = $this->removePadding($plainAscii);
        $plaintext = $this->asciiToString($plainAscii);

        $this->encryptionHistory[] = "=== Final Results ===";
        $this->encryptionHistory[] = "Recovered Plaintext: \"$plaintext\"";

        $isValid = $this->isValidPlaintext($plaintext);

        $result = [
            'plaintext' => $plaintext,
            'history' => $this->encryptionHistory,
            'factors' => $this->cognitiveFactors,
            'drift' => $this->drift,
            'weighted_drift' => $this->weightedDrift,
            'is_valid' => $isValid,
            'password_verified' => $passwordVerified,
            'block_size' => $blockSize,
            'num_blocks' => count($blocks),
            'hex_string' => $cleanHexString
        ];

        return $result;
    }

    /**
     * Check if plaintext appears to be valid
     */
    private function isValidPlaintext($text) {
        if (empty($text)) {
            return false;
        }

        $printableCount = 0;
        $totalLength = strlen($text);

        for ($i = 0; $i < $totalLength; $i++) {
            $charCode = ord($text[$i]);
            if ($charCode >= 32 && $charCode <= 126) {
                $printableCount++;
            }
        }

        if ($totalLength > 0) {
            $printableRatio = $printableCount / $totalLength;
            return $printableRatio >= 0.7;
        }

        return false;
    }

    /**
     * Browser display analysis (right-hand panel of the result view)
     */
    private function displayBrowserAnalysis($result) {
        $html = '<div class="analysis-container">';
        $html .= '<div class="panel-head"><div class="step-badge">&#9638;</div><div><h2>Process Analysis</h2><p>Parameters and the full step-by-step trace of this operation.</p></div></div>';

        $html .= '<div class="summary-section">';
        $html .= '<div class="card-title">Summary</div>';
        $html .= '<div class="summary-grid">';
        
        if (isset($result['factors'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Cognitive Factors</span><span class="summary-val">' . implode(", ", $result['factors']) . '</span></div>';
        }
        if (isset($result['drift'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Regular Drift</span><span class="summary-val">' . sprintf("%.4f", $result['drift']) . '</span></div>';
        }
        if (isset($result['weighted_drift'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Weighted Drift</span><span class="summary-val">' . sprintf("%.4f", $result['weighted_drift']) . '</span></div>';
        }
        if (isset($result['initial_key'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Initial Key</span><span class="summary-val">[' . implode(", ", $result['initial_key']) . ']</span></div>';
        }
        if (isset($result['is_valid'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Text Validity</span><span class="summary-val ' . ($result['is_valid'] ? 'valid' : 'suspicious') . '">' . ($result['is_valid'] ? '✓ VALID' : '⚠️ SUSPICIOUS') . '</span></div>';
        }
        if (isset($result['password_verified'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Password Verification</span><span class="summary-val ' . ($result['password_verified'] ? 'verified' : 'not-verified') . '">' . ($result['password_verified'] ? '✓ CORRECT' : '✗ INCORRECT') . '</span></div>';
        }
        if (isset($result['block_size'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Block Size</span><span class="summary-val">' . $result['block_size'] . '</span></div>';
        }
        if (isset($result['num_blocks'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Number of Blocks</span><span class="summary-val">' . $result['num_blocks'] . '</span></div>';
        }
        
        $html .= '</div></div>';

        $html .= '<div class="history-section">';
        $html .= '<div class="card-title">Process History</div>';
        $html .= '<div class="history-list">';
        foreach ($result['history'] as $line) {
            $cls = 'history-item';
            if (strpos($line, '===') === 0) {
                $cls .= ' h';
            } elseif (strpos($line, '---') === 0) {
                $cls .= ' sub';
            } elseif (strpos($line, '    ') === 0) {
                $cls .= ' op';
            } elseif (strpos($line, '✓') === 0) {
                $cls .= ' ok';
            }
            $html .= '<div class="' . $cls . '">' . htmlspecialchars($line) . '</div>';
        }
        $html .= '</div></div>';

        $html .= '</div>';
        return $html;
    }

    /**
     * Browser save ciphertext details
     */
    private function saveCiphertextDetailsBrowser($result, $plaintext, $password) {
        $filename = "ciphertext_" . date("Ymd_His") . ".txt";

        $content = "==================================================\n";
        $content .= "COGNITIVE METAMORPHIC CIPHER - ENCRYPTED DATA\n";
        $content .= "Generated by: {$this->developerName}\n";
        $content .= "Date: " . date('Y-m-d H:i:s') . "\n";
        $content .= "Version: 2.5 WITH ENHANCED BROWSER INTERFACE\n";
        $content .= "==================================================\n\n";

        $content .= "⚠️  EXACT PASSWORD REQUIRED ⚠️\n";
        $content .= "Password will be automatically verified during decryption.\n\n";

        $content .= "ENCRYPTION PARAMETERS:\n";
        $content .= str_repeat("-", 40) . "\n";
        $content .= "Plaintext: $plaintext\n";
        $content .= "Password: '$password'\n";
        $content .= "Cognitive Factors: " . implode(", ", $result['factors']) . "\n";
        $content .= "Regular Drift: " . sprintf("%.4f", $result['drift']) . "\n";
        $content .= "Weighted Drift: " . sprintf("%.4f", $result['weighted_drift']) . "\n";
        $content .= "Block Size: " . $result['block_size'] . "\n";
        if (isset($result['num_blocks'])) {
            $content .= "Number of Blocks: " . $result['num_blocks'] . "\n";
        }
        $content .= "\n";

        $content .= "ENCRYPTION RESULTS:\n";
        $content .= str_repeat("-", 40) . "\n";
        $content .= "Ciphertext (HEX String): " . $result['hex_string'] . "\n";
        $content .= "Initial Drifted Key: [" . implode(", ", $result['initial_key']) . "]\n";
        if (isset($result['verification_code'])) {
            $content .= "Verification Code: " . $result['verification_code'] . "\n";
        }
        $content .= "\n";

        $content .= "DECRYPTION INSTRUCTIONS:\n";
        $content .= str_repeat("-", 40) . "\n";
        $content .= "1. HEX String: " . $result['hex_string'] . "\n";
        $content .= "2. Password: '$password'\n";
        $content .= "3. Cognitive Factors: " . implode(", ", $result['factors']) . "\n";
        $content .= "4. Block Size: " . $result['block_size'] . "\n";
        $content .= "==================================================\n";

        if (file_put_contents($filename, $content)) {
            return [
                'success' => true,
                'filename' => $filename,
                'message' => "Ciphertext details saved successfully to: $filename"
            ];
        } else {
            return [
                'success' => false,
                'message' => "Error saving ciphertext details"
            ];
        }
    }

    /**
     * Browser explanation (card grid)
     */
    private function displayBrowserExplanation() {
        $html = '<div class="explain-grid">';

        // Developer card
        $html .= '<div class="card developer-info">';
        $html .= '<div class="card-title">Project</div>';
        $html .= '<div class="info-item"><span>Developed By</span><b>' . htmlspecialchars($this->developerName) . '</b></div>';
        $html .= '<div class="info-item"><span>Student ID</span><b>' . htmlspecialchars($this->studentID) . '</b></div>';
        $html .= '<div class="info-item"><span>University</span><b>' . htmlspecialchars($this->university) . '</b></div>';
        $html .= '<div class="info-item"><span>Version</span><b>' . htmlspecialchars($this->projectVersion) . '</b></div>';
        $html .= '</div>';

        // Features
        $html .= '<div class="card features-section">';
        $html .= '<div class="card-title">Improved Features</div>';
        $html .= '<ul class="features-list">';
        $html .= '<li>Enhanced Password Verification System</li>';
        $html .= '<li>Professional Browser Interface</li>';
        $html .= '<li>Improved Verification Code Generation</li>';
        $html .= '<li>Input Cleaning to Prevent Issues</li>';
        $html .= '<li>Clear Error Messages</li>';
        $html .= '</ul>';
        $html .= '</div>';

        // How it works
        $html .= '<div class="card wide">';
        $html .= '<div class="card-title">How the cipher works</div>';
        $html .= '<div class="algo-steps">';
        $html .= '<div class="algo-step"><b>1 &middot; Cognitive drift</b><p>The 3 cognitive factors give a regular drift (average) and a weighted drift that emphasises higher values.</p></div>';
        $html .= '<div class="algo-step"><b>2 &middot; Drifted key</b><p>Every password byte is shifted using the weighted drift, so the same password produces a different key for different factors.</p></div>';
        $html .= '<div class="algo-step"><b>3 &middot; Block operations</b><p>Data is split into blocks. Operations rotate XOR, ADD and SUB block by block.</p></div>';
        $html .= '<div class="algo-step"><b>4 &middot; Metamorphic key</b><p>After each block the key mutates using that block sum, so every block is encrypted with a new key.</p></div>';
        $html .= '</div>';
        $html .= '</div>';

        // Usage
        $html .= '<div class="card usage-section">';
        $html .= '<div class="card-title">How to use</div>';
        $html .= '<div class="usage-subsection"><div class="subsection-title">1. During Encryption</div>';
        $html .= '<ul><li>Enter plaintext, password, 3 cognitive factors, block size</li>';
        $html .= '<li>System stores verification data automatically</li></ul></div>';
        $html .= '<div class="usage-subsection"><div class="subsection-title">2. During Decryption</div>';
        $html .= '<ul><li>Enter HEX string, EXACT password, EXACT factors, EXACT block size</li>';
        $html .= '<li>System verifies password automatically</li>';
        $html .= '<li>Wrong password shows clear error message</li></ul></div>';
        $html .= '</div>';

        // Notes
        $html .= '<div class="card important-notes">';
        $html .= '<div class="card-title">Important Notes</div>';
        $html .= '<ul>';
        $html .= '<li>Password must match EXACTLY (case-sensitive)</li>';
        $html .= '<li>Cognitive factors must be EXACTLY 3 values</li>';
        $html .= '<li>Block size must match EXACTLY</li>';
        $html .= '<li>All inputs are automatically trimmed</li>';
        $html .= '</ul>';
        $html .= '</div>';

        $html .= '</div>';
        return $html;
    }

    /**
     * Clear verification file
     */
    private function clearVerificationFile() {
        if (file_exists($this->passwordVerificationFile)) {
            file_put_contents($this->passwordVerificationFile, "");
            return "✓ Encrypted verification file cleared.";
        } else {
            return "Verification file does not exist.";
        }
    }

    /**
     * Browser Interface
     */
    public function mainBrowser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleBrowserPost();
        }
        
        return $this->displayBrowserInterface();
    }

    /**
     * Handle browser POST requests
     */
    private function handleBrowserPost() {
        $action = $_POST['action'] ?? '';
        
        switch ($action) {
            case 'encrypt':
                $plaintext = $_POST['plaintext'] ?? '';
                $password = $_POST['password'] ?? '';
                $factors = $_POST['factors'] ?? '';
                $blockSize = intval($_POST['block_size'] ?? 0);
                
                $result = $this->encrypt($plaintext, $password, $factors, $blockSize);
                
                if (isset($result['error'])) {
                    return $this->displayBrowserInterface($result['error'], 'error', 'encrypt');
                }
                
                return $this->displayBrowserResult($result, 'encrypt');
                
            case 'decrypt':
                $hexString = $_POST['hex_string'] ?? '';
                $password = $_POST['password'] ?? '';
                $factors = $_POST['factors'] ?? '';
                $blockSize = intval($_POST['block_size'] ?? 0);
                
                try {
                    $ciphertext = hex2bin($hexString);
                    if ($ciphertext === false) {
                        return $this->displayBrowserInterface('Invalid hex string!', 'error', 'decrypt');
                    }
                } catch (Exception $e) {
                    return $this->displayBrowserInterface('Invalid hex string format!', 'error', 'decrypt');
                }
                
                $result = $this->decrypt($ciphertext, $password, $factors, $blockSize, $hexString);
                
                if (isset($result['error'])) {
                    return $this->displayBrowserInterface($result['error'], 'error', 'decrypt');
                }
                
                if (!$result['password_verified']) {
                    return $this->displayBrowserInterface('Password verification failed! Please enter the exact password used during encryption.', 'error', 'decrypt');
                }
                
                return $this->displayBrowserResult($result, 'decrypt');
                
            case 'save':
                $plaintext = $_POST['plaintext'] ?? '';
                $password = $_POST['password'] ?? '';
                $hex_string = $_POST['hex_string'] ?? '';
                $factors = $_POST['factors'] ?? '';
                $drift = $_POST['drift'] ?? '';
                $weighted_drift = $_POST['weighted_drift'] ?? '';
                $block_size = $_POST['block_size'] ?? '';
                $num_blocks = $_POST['num_blocks'] ?? '';
                $initial_key = $_POST['initial_key'] ?? '';
                
                $result = [
                    'hex_string' => $hex_string,
                    'factors' => explode(',', $factors),
                    'drift' => $drift,
                    'weighted_drift' => $weighted_drift,
                    'initial_key' => explode(',', $initial_key),
                    'block_size' => $block_size,
                    'num_blocks' => $num_blocks
                ];
                
                $saveResult = $this->saveCiphertextDetailsBrowser($result, $plaintext, $password);
                
                if ($saveResult['success']) {
                    return $this->displayBrowserInterface($saveResult['message'], 'success', 'encrypt');
                } else {
                    return $this->displayBrowserInterface($saveResult['message'], 'error', 'encrypt');
                }
                
            case 'clear_verification':
                $message = $this->clearVerificationFile();
                return $this->displayBrowserInterface($message, 'info', 'tools');
                
            case 'explanation':
                return $this->displayBrowserExplanation();
        }
        
        return $this->displayBrowserInterface();
    }

    /**
     * Display main browser interface (full-screen workspace)
     */
    private function displayBrowserInterface($message = '', $messageType = '', $active = 'encrypt') {
        $html = $this->getBrowserHeader('main', $active);

        if ($message) {
            $icons = ['success' => '✓', 'error' => '⚠', 'info' => 'ℹ'];
            $icon = isset($icons[$messageType]) ? $icons[$messageType] : 'ℹ';
            $html .= '<div class="toast message ' . htmlspecialchars($messageType) . '">'
                   . '<span class="toast-icon">' . $icon . '</span>'
                   . '<span class="toast-text">' . htmlspecialchars($message) . '</span>'
                   . '<button type="button" class="toast-close" onclick="this.parentNode.remove()">&times;</button>'
                   . '</div>';
        }

        $a = function($k) use ($active) { return $active === $k ? ' active' : ''; };

        // ================= ENCRYPT =================
        $html .= '<div id="encrypt-tab" class="tab-pane' . $a('encrypt') . '">';
        $html .= '<div class="workspace">';

        $html .= '<section class="panel accent">';
        $html .= '<div class="panel-head"><div class="step-badge">01</div><div><h2>Encrypt a message</h2><p>Remember your password, factors and block size. You need them exactly to decrypt later.</p></div></div>';
        $html .= '<form method="POST" class="cipher-form" autocomplete="off">';
        $html .= '<input type="hidden" name="action" value="encrypt">';
        $html .= '<div class="field"><label for="plaintext">Text to encrypt</label>';
        $html .= '<textarea id="plaintext" name="plaintext" rows="3" required placeholder="Enter your secret message here..."></textarea></div>';
        $html .= '<div class="field"><label for="password">Password <em>case-sensitive</em></label>';
        $html .= '<div class="input-wrap"><input type="password" id="password" name="password" required placeholder="Enter a strong password">';
        $html .= '<button type="button" class="eye" onclick="togglePw(this)">Show</button></div></div>';
        $html .= '<div class="row-2">';
        $html .= '<div class="field"><label for="factors">Cognitive factors <em>3 values, 0 to 1</em></label>';
        $html .= '<input type="text" id="factors" name="factors" required placeholder="0.25,0.50,0.75" oninput="updateLive()">';
        $html .= '<small class="hint">Memory, Adaptability, Attention</small></div>';
        $html .= '<div class="field"><label for="block_size">Block size <em>integer &ge; 1</em></label>';
        $html .= '<input type="number" id="block_size" name="block_size" min="1" value="4" required></div>';
        $html .= '</div>';
        $html .= '<button type="submit" class="btn btn-block btn-encrypt">🔒 Encrypt Message</button>';
        $html .= '</form>';
        $html .= '</section>';

        $html .= '<aside class="panel side">';
        $html .= '<div class="card">';
        $html .= '<div class="card-title">Live drift preview <span id="live-status" class="pill">0 / 3 factors</span></div>';
        $names = ['Memory', 'Adaptability', 'Attention'];
        foreach ($names as $i => $n) {
            $html .= '<div class="meter-row"><span class="m-name">Factor ' . ($i + 1) . ' &middot; ' . $n . '</span><span class="m-val" id="val-' . $i . '">&mdash;</span>';
            $html .= '<div class="meter"><i id="bar-' . $i . '"></i></div></div>';
        }
        $html .= '<div class="drift-grid">';
        $html .= '<div class="stat"><label>Drift</label><div class="v" id="live-drift">&mdash;</div></div>';
        $html .= '<div class="stat"><label>Weighted drift</label><div class="v" id="live-wdrift">&mdash;</div></div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= '<div class="card">';
        $html .= '<div class="card-title">Encryption pipeline</div>';
        $html .= '<div class="flow">';
        $flowE = [
            ['Parse input', 'Plaintext and password become ASCII bytes.'],
            ['Cognitive drift', 'Weighted drift is computed from the 3 factors.'],
            ['Drifted key', 'Password bytes are shifted by the weighted drift.'],
            ['Metamorphic blocks', 'XOR / ADD / SUB cycle, key mutates per block.'],
            ['HEX ciphertext', 'Output is produced and a verification code stored.'],
        ];
        foreach ($flowE as $i => $f) {
            $html .= '<div class="flow-step" style="--i:' . $i . '"><div class="flow-num">' . ($i + 1) . '</div><div><b>' . $f[0] . '</b><p>' . $f[1] . '</p></div></div>';
        }
        $html .= '</div></div>';
        $html .= '</aside>';

        $html .= '</div></div>';

        // ================= DECRYPT =================
        $html .= '<div id="decrypt-tab" class="tab-pane' . $a('decrypt') . '">';
        $html .= '<div class="workspace">';

        $html .= '<section class="panel accent">';
        $html .= '<div class="panel-head"><div class="step-badge">02</div><div><h2>Decrypt a message</h2><p>Provide the exact HEX string and the same parameters used during encryption.</p></div></div>';
        $html .= '<form method="POST" class="cipher-form" autocomplete="off">';
        $html .= '<input type="hidden" name="action" value="decrypt">';
        $html .= '<div class="field"><label for="hex_string">HEX string</label>';
        $html .= '<textarea id="hex_string" name="hex_string" rows="3" required placeholder="Enter the hex ciphertext..."></textarea></div>';
        $html .= '<div class="field"><label for="password_decrypt">Password <em>exact, case-sensitive</em></label>';
        $html .= '<div class="input-wrap"><input type="password" id="password_decrypt" name="password" required placeholder="Enter the exact password">';
        $html .= '<button type="button" class="eye" onclick="togglePw(this)">Show</button></div></div>';
        $html .= '<div class="row-2">';
        $html .= '<div class="field"><label for="factors_decrypt">Cognitive factors <em>exact 3 values</em></label>';
        $html .= '<input type="text" id="factors_decrypt" name="factors" required placeholder="Must match encryption exactly"></div>';
        $html .= '<div class="field"><label for="block_size_decrypt">Block size <em>must match</em></label>';
        $html .= '<input type="number" id="block_size_decrypt" name="block_size" min="1" required></div>';
        $html .= '</div>';
        $html .= '<button type="submit" class="btn btn-block btn-decrypt">🔓 Decrypt Message</button>';
        $html .= '</form>';
        $html .= '</section>';

        $html .= '<aside class="panel side">';
        $html .= '<div class="card">';
        $html .= '<div class="card-title">Must match exactly</div>';
        $html .= '<ul class="check-list">';
        $html .= '<li><span>✓</span> HEX ciphertext from the encryption result</li>';
        $html .= '<li><span>✓</span> Password, including upper and lower case</li>';
        $html .= '<li><span>✓</span> The same 3 cognitive factors</li>';
        $html .= '<li><span>✓</span> The same block size</li>';
        $html .= '</ul>';
        $html .= '</div>';

        $html .= '<div class="card">';
        $html .= '<div class="card-title">Decryption pipeline</div>';
        $html .= '<div class="flow">';
        $flowD = [
            ['Parse HEX', 'The HEX string is converted back to bytes.'],
            ['Verify password', 'A verification code is compared with the stored one.'],
            ['Rebuild key', 'The same drifted key is regenerated.'],
            ['Reverse blocks', 'Each block operation is reversed in order.'],
            ['Recover text', 'Padding is removed and plaintext is restored.'],
        ];
        foreach ($flowD as $i => $f) {
            $html .= '<div class="flow-step" style="--i:' . $i . '"><div class="flow-num">' . ($i + 1) . '</div><div><b>' . $f[0] . '</b><p>' . $f[1] . '</p></div></div>';
        }
        $html .= '</div></div>';
        $html .= '</aside>';

        $html .= '</div></div>';

        // ================= EXPLANATION =================
        $html .= '<div id="explanation-tab" class="tab-pane' . $a('explanation') . '">';
        $html .= $this->displayBrowserExplanation();
        $html .= '</div>';

        // ================= TOOLS =================
        $html .= '<div id="tools-tab" class="tab-pane' . $a('tools') . '">';
        $html .= '<div class="explain-grid">';
        $html .= '<div class="card tool-card">';
        $html .= '<div class="card-title">🛠️ Clear verification data</div>';
        $html .= '<p>Clear all stored password verification data. After clearing, previously encrypted messages can no longer be verified or decrypted.</p>';
        $html .= '<div class="file-chip">' . htmlspecialchars($this->passwordVerificationFile) . '</div>';
        $html .= '<form method="POST" class="tool-form">';
        $html .= '<input type="hidden" name="action" value="clear_verification">';
        $html .= '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to clear ALL verification data?\')">🗑️ Clear Verification File</button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        $html .= $this->getBrowserFooter();

        return $html;
    }

    /**
     * Display result view (split: result left, analysis right)
     */
    private function displayBrowserResult($result, $type) {
        $isEnc = ($type === 'encrypt');

        if ($isEnc) {
            $title = 'Encryption Result';
            $sub = 'Your message was transformed using weighted cognitive drift';
        } else {
            $title = 'Decryption Result';
            $sub = $result['is_valid'] ? 'Password verified and original text recovered' : 'Decryption finished, but the text looks suspicious';
        }

        $html = $this->getBrowserHeader('result', '', $title, $sub);

        $html .= '<div class="workspace">';
        $html .= '<section class="panel accent">';

        // Status banner
        if ($isEnc) {
            $html .= '<div class="status success"><div class="status-icon">🔒</div><div><h2>Encryption Complete!</h2><p>Ciphertext generated and verification code stored.</p></div></div>';
        } else {
            $ok = $result['is_valid'];
            $html .= '<div class="status ' . ($ok ? 'success' : 'warning') . '"><div class="status-icon">' . ($ok ? '🔓' : '⚠️') . '</div><div><h2>' . ($ok ? 'Decryption Successful!' : 'Decryption Warning') . '</h2><p>' . ($ok ? 'The original message has been recovered.' : 'Please double check the cognitive factors and block size.') . '</p></div></div>';
        }

        // Stats
        $html .= '<div class="stat-grid">';
        $html .= '<div class="stat"><label>Block Size</label><div class="v">' . $result['block_size'] . '</div></div>';
        $html .= '<div class="stat"><label>Blocks</label><div class="v">' . $result['num_blocks'] . '</div></div>';
        $html .= '<div class="stat"><label>Weighted Drift</label><div class="v">' . sprintf("%.4f", $result['weighted_drift']) . '</div></div>';
        if ($isEnc) {
            $html .= '<div class="stat"><label>Regular Drift</label><div class="v">' . sprintf("%.4f", $result['drift']) . '</div></div>';
        } else {
            $html .= '<div class="stat"><label>Password</label><div class="v ' . ($result['password_verified'] ? 'verified' : 'not-verified') . '">' . ($result['password_verified'] ? '✓ Verified' : '✗ Failed') . '</div></div>';
        }
        $html .= '</div>';

        // Outputs
        if ($isEnc) {
            $html .= '<div class="out"><div class="out-head"><span>Original text</span></div>';
            $html .= '<div class="out-box plain">' . htmlspecialchars($result['plaintext']) . '</div></div>';

            $html .= '<div class="out"><div class="out-head"><span>Ciphertext (HEX)</span>';
            $html .= '<button type="button" class="copy-mini" data-copy="' . htmlspecialchars($result['hex_string'], ENT_QUOTES) . '" onclick="copyFrom(this)">📋 Copy HEX</button></div>';
            $html .= '<div class="out-box hex-string">' . htmlspecialchars($result['hex_string']) . '</div></div>';
        } else {
            $html .= '<div class="out"><div class="out-head"><span>Ciphertext (HEX)</span></div>';
            $html .= '<div class="out-box hex-string">' . htmlspecialchars($result['hex_string']) . '</div></div>';

            $html .= '<div class="out"><div class="out-head"><span>Recovered text <b class="tag ' . ($result['is_valid'] ? 'valid' : 'suspicious') . '">' . ($result['is_valid'] ? '✓ VALID' : '⚠️ SUSPICIOUS') . '</b></span>';
            $html .= '<button type="button" class="copy-mini" data-copy="' . htmlspecialchars($result['plaintext'], ENT_QUOTES) . '" onclick="copyFrom(this)">📋 Copy Text</button></div>';
            $html .= '<div class="out-box recovered-text">' . htmlspecialchars($result['plaintext']) . '</div></div>';
        }

        // Actions
        $html .= '<div class="result-actions">';
        if ($isEnc) {
            $html .= '<form method="POST">';
            $html .= '<input type="hidden" name="action" value="save">';
            $html .= '<input type="hidden" name="plaintext" value="' . htmlspecialchars($result['plaintext']) . '">';
            $html .= '<input type="hidden" name="password" value="' . htmlspecialchars($result['password']) . '">';
            $html .= '<input type="hidden" name="hex_string" value="' . $result['hex_string'] . '">';
            $html .= '<input type="hidden" name="factors" value="' . implode(',', $result['factors']) . '">';
            $html .= '<input type="hidden" name="drift" value="' . $result['drift'] . '">';
            $html .= '<input type="hidden" name="weighted_drift" value="' . $result['weighted_drift'] . '">';
            $html .= '<input type="hidden" name="block_size" value="' . $result['block_size'] . '">';
            $html .= '<input type="hidden" name="num_blocks" value="' . $result['num_blocks'] . '">';
            $html .= '<input type="hidden" name="initial_key" value="' . implode(',', $result['initial_key']) . '">';
            $html .= '<button type="submit" class="btn btn-save">💾 Save Details</button>';
            $html .= '</form>';
        }
        $html .= '<a href="?" class="btn btn-ghost">&larr; Back to Main</a>';
        $html .= '</div>';

        $html .= '</section>';

        $html .= '<aside class="panel">';
        $html .= $this->displayBrowserAnalysis($result);
        $html .= '</aside>';

        $html .= '</div>';

        $html .= $this->getBrowserFooter();

        return $html;
    }

    /**
     * Page head + app shell opening (sidebar, top bar). Leaves <div class="content"> open.
     */
    private function getBrowserHeader($mode = 'main', $active = 'encrypt', $title = null, $sub = null) {
        if ($title === null || $sub === null) {
            $meta = $this->getTabMeta();
            $key = isset($meta[$active]) ? $active : 'encrypt';
            $title = $meta[$key]['title'];
            $sub = $meta[$key]['sub'];
        }

        $html = <<<'CMCHEAD'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cognitive Metamorphic Cipher System</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --bg:#070a12;
    --panel:rgba(16,23,36,.72);
    --card:rgba(255,255,255,.035);
    --line:rgba(148,163,184,.14);
    --text:#e8eef8;
    --muted:#8b9ab1;
    --teal:#2dd4bf;
    --blue:#3b82f6;
    --violet:#8b5cf6;
    --amber:#fbbf24;
    --green:#34d399;
    --red:#f87171;
    --mono:"JetBrains Mono","Courier New",monospace;
}
*{margin:0;padding:0;box-sizing:border-box}
html,body{height:100%}
body{
    font-family:"Inter","Segoe UI",Tahoma,sans-serif;
    background:var(--bg);
    color:var(--text);
    overflow:hidden;
    line-height:1.5;
}

/* ===== Animated background ===== */
body::before{
    content:"";position:fixed;inset:-10%;z-index:0;pointer-events:none;
    background:
        radial-gradient(600px 420px at 12% 8%,rgba(45,212,191,.16),transparent 60%),
        radial-gradient(720px 520px at 92% 92%,rgba(139,92,246,.17),transparent 60%),
        radial-gradient(520px 420px at 72% 8%,rgba(59,130,246,.12),transparent 60%);
    animation:aurora 22s ease-in-out infinite alternate;
}
body::after{
    content:"";position:fixed;inset:0;z-index:0;pointer-events:none;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
    background-size:48px 48px;
    -webkit-mask-image:radial-gradient(circle at 55% 35%,#000 15%,transparent 75%);
    mask-image:radial-gradient(circle at 55% 35%,#000 15%,transparent 75%);
    animation:gridDrift 30s linear infinite;
}
@keyframes aurora{0%{transform:translate3d(0,0,0) scale(1)}100%{transform:translate3d(-3%,2%,0) scale(1.1)}}
@keyframes gridDrift{from{background-position:0 0,0 0}to{background-position:48px 48px,48px 48px}}

/* ===== App shell ===== */
.app{position:relative;z-index:1;display:grid;grid-template-columns:276px 1fr;height:100vh;height:100dvh}

/* ===== Sidebar ===== */
.sidebar{
    display:flex;flex-direction:column;gap:24px;padding:22px 16px;
    background:linear-gradient(180deg,rgba(12,18,30,.94),rgba(8,12,21,.96));
    border-right:1px solid var(--line);overflow-y:auto;
    animation:slideInLeft .7s cubic-bezier(.2,.8,.2,1) both;
}
@keyframes slideInLeft{from{opacity:0;transform:translateX(-24px)}to{opacity:1;transform:none}}
.brand{display:flex;gap:12px;align-items:center;padding:4px 8px}
.brand-mark{width:46px;height:46px;flex:none;filter:drop-shadow(0 0 14px rgba(45,212,191,.35));animation:markFloat 5s ease-in-out infinite}
@keyframes markFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-4px)}}
.brand-name{font-weight:800;font-size:.98em;line-height:1.2}
.brand-sub{font-size:.7em;color:var(--teal);letter-spacing:2.4px;text-transform:uppercase;margin-top:3px;font-weight:600}
.nav-label{font-size:.7em;letter-spacing:2px;text-transform:uppercase;color:#5d6c85;font-weight:700;padding:0 10px;margin-bottom:10px}
.nav{display:flex;flex-direction:column;gap:6px}
.nav-item{
    position:relative;display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:14px;
    border:1px solid transparent;background:transparent;color:var(--muted);font:inherit;font-weight:600;font-size:.94em;
    cursor:pointer;text-decoration:none;text-align:left;overflow:hidden;transition:all .3s ease;
}
.nav-item .ico{width:36px;height:36px;display:grid;place-items:center;border-radius:11px;background:rgba(255,255,255,.05);font-size:1.05em;transition:all .3s ease;flex:none}
.nav-text small{display:block;font-weight:400;font-size:.76em;color:#6b7b95;margin-top:1px}
.nav-item::before{
    content:"";position:absolute;left:0;top:22%;bottom:22%;width:3px;border-radius:3px;
    background:linear-gradient(var(--teal),var(--blue));transform:scaleY(0);transition:transform .3s ease;
}
.nav-item:hover{color:var(--text);background:rgba(255,255,255,.05);transform:translateX(3px)}
.nav-item.active{color:#fff;background:linear-gradient(90deg,rgba(45,212,191,.17),rgba(59,130,246,.05));border-color:rgba(45,212,191,.28)}
.nav-item.active::before{transform:scaleY(1)}
.nav-item.active .ico{background:linear-gradient(135deg,var(--teal),var(--blue));box-shadow:0 6px 18px rgba(45,212,191,.35)}
.nav-item.active .nav-text small{color:#a7b6cd}

.team-card{margin-top:auto;padding:16px;border-radius:16px;background:rgba(255,255,255,.04);border:1px solid var(--line)}
.team-title{font-size:.7em;letter-spacing:1.4px;text-transform:uppercase;color:var(--teal);font-weight:700;margin-bottom:12px;line-height:1.5}
.team-row{display:flex;justify-content:space-between;gap:10px;padding:7px 0;border-bottom:1px dashed rgba(148,163,184,.14);font-size:.8em}
.team-row:last-child{border-bottom:none}
.team-row span{color:var(--muted)}
.team-row b{font-weight:600;text-align:right;color:var(--text)}

/* ===== Main column ===== */
.main{display:flex;flex-direction:column;min-width:0;height:100vh;height:100dvh}
.topbar{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 28px 12px;animation:fadeUp .7s .1s both}
.topbar h1{font-size:1.55em;font-weight:800;letter-spacing:-.3px;background:linear-gradient(90deg,#fff,#a5f3fc 60%,#c4b5fd);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
.topbar p{color:var(--muted);font-size:.9em;margin-top:2px}
.chips{display:flex;gap:10px;flex-wrap:wrap}
.chip{display:inline-flex;align-items:center;gap:8px;padding:7px 13px;border-radius:999px;border:1px solid var(--line);background:rgba(255,255,255,.04);font-size:.78em;font-weight:600;color:var(--muted)}
.dot{width:8px;height:8px;border-radius:50%;background:var(--green);animation:pulse 2s infinite}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(52,211,153,.6)}70%{box-shadow:0 0 0 9px rgba(52,211,153,0)}100%{box-shadow:0 0 0 0 rgba(52,211,153,0)}}
.content{flex:1;min-height:0;padding:6px 28px 16px;position:relative}
.statusbar{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:10px 28px;border-top:1px solid var(--line);font-size:.76em;color:var(--muted);background:rgba(6,9,16,.65)}

/* ===== Panes / workspace ===== */
.tab-pane{display:none;height:100%;overflow:auto}
.tab-pane.active{display:block;animation:fadeUp .55s cubic-bezier(.2,.8,.2,1) both}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
.workspace{display:grid;grid-template-columns:minmax(380px,1.08fr) minmax(320px,1fr);grid-template-rows:minmax(0,1fr);gap:20px;height:100%;animation:fadeUp .6s both}
.content>.workspace{height:100%}

.panel{
    position:relative;min-height:0;overflow:auto;padding:26px;border-radius:22px;
    background:var(--panel);border:1px solid var(--line);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
    box-shadow:0 20px 50px rgba(0,0,0,.35),inset 0 1px 0 rgba(255,255,255,.04);
}
.panel.accent::before{
    content:"";position:absolute;top:0;left:26px;right:26px;height:2px;
    background:linear-gradient(90deg,transparent,var(--teal),var(--blue),var(--violet),transparent);
    background-size:200% 100%;animation:slideBar 4s linear infinite;
}
@keyframes slideBar{from{background-position:200% 0}to{background-position:-200% 0}}
.panel::-webkit-scrollbar,.tab-pane::-webkit-scrollbar,.history-list::-webkit-scrollbar,.sidebar::-webkit-scrollbar,.out-box::-webkit-scrollbar{width:8px;height:8px}
.panel::-webkit-scrollbar-thumb,.tab-pane::-webkit-scrollbar-thumb,.history-list::-webkit-scrollbar-thumb,.sidebar::-webkit-scrollbar-thumb,.out-box::-webkit-scrollbar-thumb{background:rgba(99,120,170,.4);border-radius:8px}

.panel-head{display:flex;gap:14px;align-items:flex-start;margin-bottom:22px}
.step-badge{
    width:44px;height:44px;flex:none;border-radius:13px;display:grid;place-items:center;
    font-family:var(--mono);font-weight:700;color:var(--teal);
    background:linear-gradient(135deg,rgba(45,212,191,.2),rgba(59,130,246,.2));border:1px solid rgba(45,212,191,.35);
}
.panel-head h2{font-size:1.2em;font-weight:700}
.panel-head p{color:var(--muted);font-size:.88em;margin-top:2px}

/* ===== Forms ===== */
.field{margin-bottom:18px}
.field label{display:flex;justify-content:space-between;gap:10px;font-size:.76em;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#a9b8d2;margin-bottom:8px}
.field label em{font-style:normal;font-weight:500;letter-spacing:.3px;text-transform:none;color:#64748b}
.field input,.field textarea{
    width:100%;padding:13px 15px;background:rgba(5,8,14,.65);border:1px solid var(--line);border-radius:12px;
    color:var(--text);font:inherit;font-size:.96em;transition:all .3s ease;
}
.field textarea{min-height:92px;resize:vertical}
.field input::placeholder,.field textarea::placeholder{color:#4f5f7a}
.field input:focus,.field textarea:focus{outline:none;border-color:var(--teal);background:rgba(5,8,14,.9);box-shadow:0 0 0 4px rgba(45,212,191,.14),0 0 24px rgba(59,130,246,.12)}
.hint{display:block;margin-top:6px;color:#64748b;font-size:.78em}
.input-wrap{position:relative}
.input-wrap input{padding-right:70px}
.eye{position:absolute;right:8px;top:50%;transform:translateY(-50%);padding:6px 10px;border-radius:8px;border:1px solid var(--line);background:rgba(255,255,255,.06);color:var(--muted);font:inherit;font-size:.74em;font-weight:600;cursor:pointer;transition:all .25s ease}
.eye:hover{color:#fff;background:rgba(255,255,255,.12)}
.row-2{display:grid;grid-template-columns:1.6fr 1fr;gap:14px}

.btn{
    position:relative;overflow:hidden;display:inline-flex;align-items:center;justify-content:center;gap:10px;
    padding:14px 22px;border:1px solid transparent;border-radius:12px;font:inherit;font-weight:700;font-size:.95em;color:#fff;
    cursor:pointer;text-decoration:none;letter-spacing:.4px;transition:all .3s ease;
}
.btn::after{content:"";position:absolute;top:0;left:-80%;width:50%;height:100%;background:linear-gradient(120deg,transparent,rgba(255,255,255,.35),transparent);transform:skewX(-20deg);transition:left .7s ease}
.btn:hover::after{left:130%}
.btn:hover{transform:translateY(-3px);filter:brightness(1.08)}
.btn:active{transform:translateY(-1px)}
.btn-block{width:100%;margin-top:6px;padding:16px;text-transform:uppercase;letter-spacing:1.4px}
.btn-encrypt{background:linear-gradient(135deg,#14b8a6,#3b82f6);box-shadow:0 12px 28px rgba(20,184,166,.28)}
.btn-decrypt{background:linear-gradient(135deg,#8b5cf6,#3b82f6);box-shadow:0 12px 28px rgba(139,92,246,.3)}
.btn-save{background:linear-gradient(135deg,#7c3aed,#a78bfa);box-shadow:0 10px 24px rgba(124,58,237,.3)}
.btn-danger{background:linear-gradient(135deg,#dc2626,#f97316);box-shadow:0 10px 24px rgba(220,38,38,.3)}
.btn-ghost{background:rgba(255,255,255,.06);border-color:var(--line);color:var(--text)}
.btn-ghost:hover{background:rgba(255,255,255,.1)}

/* ===== Side cards ===== */
.card{padding:18px;border-radius:16px;background:var(--card);border:1px solid var(--line);margin-bottom:16px}
.card:last-child{margin-bottom:0}
.card-title{display:flex;justify-content:space-between;align-items:center;gap:10px;font-size:.74em;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:14px}
.pill{padding:3px 10px;border-radius:999px;border:1px solid var(--line);background:rgba(255,255,255,.05);font-size:.95em;letter-spacing:.3px;text-transform:none;color:var(--muted)}
.pill.ok{color:var(--green);border-color:rgba(52,211,153,.4);background:rgba(52,211,153,.1)}

.meter-row{display:grid;grid-template-columns:1fr auto;gap:6px 10px;margin-bottom:12px;font-size:.85em}
.m-name{color:#b6c3da}
.m-val{font-family:var(--mono);color:var(--text)}
.meter{grid-column:1 / -1;height:8px;border-radius:8px;background:rgba(255,255,255,.07);overflow:hidden}
.meter i{display:block;height:100%;width:0;border-radius:8px;background:linear-gradient(90deg,var(--teal),var(--blue));box-shadow:0 0 12px rgba(45,212,191,.5);transition:width .5s cubic-bezier(.2,.8,.2,1)}
.drift-grid,.stat-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.drift-grid{margin-top:6px}
.stat{padding:14px 16px;border-radius:14px;background:rgba(255,255,255,.04);border:1px solid var(--line);transition:all .3s ease}
.stat:hover{border-color:rgba(45,212,191,.45);transform:translateY(-2px)}
.stat label{display:block;font-size:.7em;letter-spacing:1.3px;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:4px}
.stat .v{font-family:var(--mono);font-size:1.3em;font-weight:700}
.stat .v.verified{color:var(--green)}
.stat .v.not-verified{color:var(--red)}

.flow{position:relative;display:flex;flex-direction:column;gap:4px}
.flow::before{content:"";position:absolute;left:21px;top:22px;bottom:22px;width:2px;background:linear-gradient(var(--teal),var(--violet));opacity:.35}
.flow-step{position:relative;display:flex;gap:14px;align-items:flex-start;padding:10px 12px;border-radius:12px;border:1px solid transparent;animation:stepGlow 7.5s infinite;animation-delay:calc(var(--i) * 1.5s)}
.flow-num{position:relative;z-index:1;width:20px;height:20px;margin-left:2px;flex:none;border-radius:50%;display:grid;place-items:center;background:#0c1424;border:1px solid rgba(45,212,191,.5);font-weight:700;font-size:.66em;color:var(--teal)}
.flow-step b{font-size:.92em}
.flow-step p{color:var(--muted);font-size:.8em}
@keyframes stepGlow{
    0%{background:rgba(45,212,191,.13);border-color:rgba(45,212,191,.38)}
    17%{background:rgba(45,212,191,.13);border-color:rgba(45,212,191,.38)}
    22%,100%{background:transparent;border-color:transparent}
}
.check-list{list-style:none}
.check-list li{display:flex;gap:12px;align-items:center;padding:10px 6px;border-bottom:1px solid rgba(148,163,184,.1);font-size:.9em;color:#c6d2e6}
.check-list li:last-child{border-bottom:none}
.check-list li span{width:22px;height:22px;flex:none;display:grid;place-items:center;border-radius:50%;background:rgba(52,211,153,.14);color:var(--green);font-size:.8em;font-weight:700}

/* ===== Toast ===== */
.toast{
    position:fixed;top:20px;right:24px;z-index:60;display:flex;align-items:center;gap:12px;
    min-width:280px;max-width:480px;padding:14px 16px;border-radius:14px;border:1px solid;font-weight:600;font-size:.92em;
    backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);box-shadow:0 18px 40px rgba(0,0,0,.45);
    animation:toastIn .5s cubic-bezier(.2,.8,.2,1);
}
@keyframes toastIn{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:none}}
.toast-icon{width:26px;height:26px;flex:none;display:grid;place-items:center;border-radius:50%;background:rgba(255,255,255,.1)}
.toast-text{flex:1}
.toast-close{background:none;border:none;color:inherit;font-size:1.4em;cursor:pointer;opacity:.7;line-height:1}
.toast-close:hover{opacity:1}
.toast.success{background:rgba(8,40,32,.92);border-color:rgba(52,211,153,.55);color:#86efac}
.toast.error{background:rgba(48,14,18,.92);border-color:rgba(248,113,113,.55);color:#fca5a5;animation:toastIn .5s cubic-bezier(.2,.8,.2,1),shake .5s .5s}
.toast.info{background:rgba(8,32,48,.92);border-color:rgba(56,189,248,.55);color:#7dd3fc}
@keyframes shake{0%,100%{transform:translateX(0)}25%{transform:translateX(-6px)}75%{transform:translateX(6px)}}

/* ===== Result view ===== */
.status{display:flex;align-items:center;gap:16px;padding:18px 20px;border-radius:18px;margin-bottom:18px;border:1px solid}
.status h2{font-size:1.2em}
.status p{font-size:.86em;color:var(--muted)}
.status-icon{position:relative;width:52px;height:52px;flex:none;display:grid;place-items:center;border-radius:50%;font-size:1.5em;background:rgba(255,255,255,.08)}
.status-icon::after{content:"";position:absolute;inset:-6px;border-radius:50%;border:2px solid currentColor;opacity:.4;animation:ring 2.4s ease-out infinite}
@keyframes ring{0%{transform:scale(.85);opacity:.6}100%{transform:scale(1.35);opacity:0}}
.status.success{color:var(--green);background:linear-gradient(135deg,rgba(16,185,129,.18),rgba(45,212,191,.06));border-color:rgba(52,211,153,.4)}
.status.warning{color:var(--amber);background:linear-gradient(135deg,rgba(245,158,11,.18),rgba(239,68,68,.06));border-color:rgba(251,191,36,.4)}
.status h2{color:#fff}
.out{margin-top:18px}
.out-head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:8px;font-size:.74em;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;color:#a9b8d2}
.tag{margin-left:8px;padding:2px 9px;border-radius:999px;font-size:.95em;letter-spacing:.4px;border:1px solid}
.tag.valid{color:var(--green);border-color:rgba(52,211,153,.4);background:rgba(52,211,153,.1)}
.tag.suspicious{color:var(--amber);border-color:rgba(251,191,36,.4);background:rgba(251,191,36,.1)}
.copy-mini{padding:6px 12px;border-radius:9px;border:1px solid var(--line);background:rgba(255,255,255,.06);color:var(--text);font:inherit;font-size:.9em;font-weight:600;letter-spacing:0;text-transform:none;cursor:pointer;transition:all .25s ease}
.copy-mini:hover{background:linear-gradient(135deg,#2563eb,#38bdf8);border-color:transparent;transform:translateY(-2px)}
.out-box{max-height:170px;overflow:auto;padding:14px 16px;border-radius:12px;background:rgba(4,7,13,.75);border:1px solid var(--line);font-family:var(--mono);font-size:.9em;word-break:break-all;white-space:pre-wrap}
.out-box.hex-string{color:var(--teal)}
.out-box.recovered-text{color:var(--amber);font-weight:600}
.result-actions{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
.result-actions form{display:inline-flex}

/* ===== Analysis ===== */
.summary-section,.history-section{margin-bottom:22px}
.summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px}
.summary-item{display:flex;flex-direction:column;gap:3px;padding:12px 14px;border-radius:12px;background:rgba(255,255,255,.035);border:1px solid var(--line);transition:all .3s ease;min-width:0}
.summary-item:hover{border-color:rgba(45,212,191,.45);transform:translateY(-2px)}
.summary-label{font-size:.68em;letter-spacing:1.3px;text-transform:uppercase;color:var(--muted);font-weight:600}
.summary-val{font-family:var(--mono);font-size:.92em;word-break:break-all}
.summary-val.valid,.summary-val.verified{color:var(--green);font-weight:700}
.summary-val.suspicious{color:var(--amber);font-weight:700}
.summary-val.not-verified{color:var(--red);font-weight:700}
.history-list{padding:12px;border-radius:14px;background:#04070d;border:1px solid var(--line);font-family:var(--mono);font-size:.8em;max-height:420px;overflow:auto}
.history-item{padding:4px 8px;color:#b4c2d9;word-break:break-all;border-radius:6px}
.history-item:hover{background:rgba(255,255,255,.04)}
.history-item.h{color:var(--teal);font-weight:700;margin-top:10px}
.history-item.sub{color:var(--amber);margin-top:6px}
.history-item.op{color:#7c8ba3;padding-left:22px}
.history-item.ok{color:var(--green)}

/* ===== Explanation / tools ===== */
.explain-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:18px;padding:2px 2px 8px}
.explain-grid .card{margin:0;padding:22px;background:var(--panel);box-shadow:0 14px 34px rgba(0,0,0,.28)}
.explain-grid .card.wide{grid-column:1 / -1}
.info-item{display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px dashed rgba(148,163,184,.16);font-size:.92em}
.info-item:last-child{border-bottom:none}
.info-item span{color:var(--muted)}
.features-list,.usage-section ul,.important-notes ul{list-style:none}
.features-list li,.usage-section ul li,.important-notes ul li{padding:9px 10px;border-bottom:1px solid rgba(148,163,184,.1);border-radius:8px;font-size:.92em;color:#d3deef;transition:all .25s ease}
.features-list li:hover,.usage-section ul li:hover,.important-notes ul li:hover{background:rgba(255,255,255,.05);padding-left:16px}
.features-list li:before{content:"✓";color:var(--green);margin-right:10px;font-weight:700}
.usage-subsection{margin-bottom:14px}
.subsection-title{font-weight:700;color:var(--amber);margin-bottom:6px;font-size:.95em}
.algo-steps{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px}
.algo-step{padding:16px;border-radius:14px;background:rgba(255,255,255,.035);border:1px solid var(--line);transition:all .3s ease}
.algo-step:hover{border-color:rgba(139,92,246,.5);transform:translateY(-3px)}
.algo-step b{display:block;color:#c4b5fd;margin-bottom:6px;font-size:.92em}
.algo-step p{color:var(--muted);font-size:.84em}
.tool-card p{color:var(--muted);margin-bottom:14px;font-size:.92em}
.file-chip{display:inline-block;margin-bottom:16px;padding:6px 12px;border-radius:8px;background:rgba(4,7,13,.75);border:1px solid var(--line);font-family:var(--mono);font-size:.82em;color:var(--teal)}

.footer-line{opacity:.9}

/* ===== Responsive ===== */
@media (max-width:1100px){
    .workspace{grid-template-columns:1fr 1fr}
    .row-2{grid-template-columns:1fr}
}
@media (max-width:960px){
    body{overflow:auto}
    .app{display:block;height:auto;min-height:100vh}
    .sidebar{border-right:none;border-bottom:1px solid var(--line);padding:14px;gap:12px}
    .nav{flex-direction:row;flex-wrap:wrap}
    .nav-item{flex:1;min-width:150px}
    .team-card{display:none}
    .main{height:auto}
    .content{overflow:visible;padding:8px 14px 16px}
    .tab-pane{height:auto;overflow:visible}
    .workspace{grid-template-columns:1fr;grid-template-rows:auto;height:auto}
    .content>.workspace{height:auto}
    .panel{overflow:visible}
    .topbar{flex-direction:column;align-items:flex-start;padding:16px 14px 8px}
    .statusbar{padding:10px 14px}
    .toast{left:14px;right:14px;min-width:0;max-width:none}
    .stat-grid,.drift-grid{grid-template-columns:1fr 1fr}
}
@media (prefers-reduced-motion:reduce){
    *,*::before,*::after{animation:none !important;transition:none !important}
}
</style>
<script>
function switchTab(name){
    var pane=document.getElementById(name+"-tab");
    if(!pane){return;}
    document.querySelectorAll(".tab-pane").forEach(function(p){p.classList.remove("active");});
    pane.classList.add("active");
    document.querySelectorAll(".nav-item[data-tab]").forEach(function(b){
        if(b.tagName!=="BUTTON"){return;}
        var on=b.getAttribute("data-tab")===name;
        b.classList.toggle("active",on);
        if(on){
            var t=document.getElementById("page-title");
            var s=document.getElementById("page-sub");
            if(t){t.textContent=b.getAttribute("data-title");}
            if(s){s.textContent=b.getAttribute("data-sub");}
        }
    });
    var c=document.querySelector(".content");
    if(c){c.scrollTop=0;}
}

function togglePw(btn){
    var i=btn.parentNode.querySelector("input");
    if(!i){return;}
    var show=i.type==="password";
    i.type=show?"text":"password";
    btn.textContent=show?"Hide":"Show";
}

function doCopy(text,btn){
    function done(){
        if(!btn){return;}
        var old=btn.getAttribute("data-label")||btn.textContent;
        btn.setAttribute("data-label",old);
        btn.textContent="✓ Copied";
        setTimeout(function(){btn.textContent=old;},1600);
    }
    function fallback(){
        var ta=document.createElement("textarea");
        ta.value=text;ta.style.position="fixed";ta.style.opacity="0";
        document.body.appendChild(ta);ta.select();
        try{document.execCommand("copy");done();}catch(e){console.error(e);}
        document.body.removeChild(ta);
    }
    if(navigator.clipboard&&window.isSecureContext){
        navigator.clipboard.writeText(text).then(done).catch(fallback);
    }else{
        fallback();
    }
}
function copyFrom(btn){doCopy(btn.getAttribute("data-copy")||"",btn);}
function copyToClipboard(text){doCopy(text,null);}

function updateLive(){
    var inp=document.getElementById("factors");
    if(!inp){return;}
    var parts=inp.value.split(",").map(function(s){return s.trim();}).filter(function(s){return s!=="";});
    var vals=parts.map(function(s){
        var n=Number(s);
        if(!isFinite(n)){return null;}
        return Math.min(1,Math.max(0,n));
    });
    var ok=(parts.length===3)&&vals.every(function(v){return v!==null;});
    for(var i=0;i<3;i++){
        var bar=document.getElementById("bar-"+i);
        var val=document.getElementById("val-"+i);
        var v=(vals[i]!==undefined&&vals[i]!==null)?vals[i]:null;
        if(bar){bar.style.width=(v!==null?v*100:0)+"%";}
        if(val){val.textContent=(v!==null)?v.toFixed(2):"—";}
    }
    var d=document.getElementById("live-drift");
    var w=document.getElementById("live-wdrift");
    var st=document.getElementById("live-status");
    if(ok){
        var sum=0,num=0,den=0;
        vals.forEach(function(v){sum+=v;num+=v*v*v;den+=v*v;});
        if(d){d.textContent=(sum/3).toFixed(4);}
        if(w){w.textContent=(den>0?num/den:0).toFixed(4);}
        if(st){st.textContent="Valid · 3 factors";st.classList.add("ok");}
    }else{
        if(d){d.textContent="—";}
        if(w){w.textContent="—";}
        if(st){st.textContent=Math.min(parts.length,9)+" / 3 factors";st.classList.remove("ok");}
    }
}

document.addEventListener("DOMContentLoaded",function(){
    var hasToast=document.querySelector(".toast");
    var h=(location.hash||"").replace("#","");
    if(!hasToast&&h&&document.getElementById(h+"-tab")){switchTab(h);}
    updateLive();
});
</script>
</head>
CMCHEAD;

        $html .= '<body class="mode-' . htmlspecialchars($mode) . '">';
        $html .= '<div class="app">';
        $html .= $this->displayBrowserBanner($mode, $active);
        $html .= '<main class="main">';
        $html .= '<header class="topbar">';
        $html .= '<div><h1 id="page-title">' . htmlspecialchars($title) . '</h1><p id="page-sub">' . htmlspecialchars($sub) . '</p></div>';
        $html .= '<div class="chips"><span class="chip">v' . htmlspecialchars($this->projectVersion) . '</span><span class="chip"><i class="dot"></i>System online</span></div>';
        $html .= '</header>';
        $html .= '<div class="content">';

        return $html;
    }

    /**
     * Close content / main / app + status bar footer
     */
    private function getBrowserFooter() {
        $html = '</div>
            <footer class="statusbar">
                <span class="footer-line">© 2026 Cognitive Metamorphic Cipher System | Version ' . htmlspecialchars($this->projectVersion) . '</span>
                <span class="footer-line">Developed by ' . htmlspecialchars($this->developerName) . ' | ' . htmlspecialchars($this->studentID) . ' | ' . htmlspecialchars($this->university) . '</span>
            </footer>
        </main>
        </div>
        </body>
        </html>';
        return $html;
    }
}

// Main execution - Browser only
$cmc = new CognitiveMetamorphicCipher();
echo $cmc->mainBrowser();
?>
