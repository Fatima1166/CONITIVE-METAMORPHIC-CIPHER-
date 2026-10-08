<?php
/*
 * COGNITIVE METAMORPHIC CIPHER (CMC) SYSTEM
 * Browser Interface Only
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
     * Browser banner display
     */
    private function displayBrowserBanner() {
        $html = '
        <div class="banner-container">
            <div class="banner-header">
                <div class="banner-title">COGNITIVE METAMORPHIC CIPHER (CMC) SYSTEM</div>
                <div class="banner-subtitle">Professional Encryption & Decryption System</div>
            </div>
            <div class="banner-info">
                <div class="info-row">
                    <span class="info-label">Developers:</span>
                    <span class="info-value">' . htmlspecialchars($this->developerName) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Student ID:</span>
                    <span class="info-value">' . htmlspecialchars($this->studentID) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">University:</span>
                    <span class="info-value">' . htmlspecialchars($this->university) . '</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Version:</span>
                    <span class="info-value">' . htmlspecialchars($this->projectVersion) . ' (Enhanced Browser Interface)</span>
                </div>
            </div>
        </div>';
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
     * Browser display analysis
     */
    private function displayBrowserAnalysis($result) {
        $html = '<div class="analysis-container">';
        $html .= '<div class="analysis-header">Detailed Analysis - CMC System</div>';
        $html .= '<div class="history-section">';
        $html .= '<div class="section-title">Process History:</div>';
        $html .= '<div class="history-list">';
        
        foreach ($result['history'] as $line) {
            $html .= '<div class="history-item">' . htmlspecialchars($line) . '</div>';
        }
        
        $html .= '</div></div>';
        $html .= '<div class="summary-section">';
        $html .= '<div class="section-title">Summary Information:</div>';
        $html .= '<div class="summary-grid">';
        
        if (isset($result['factors'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Cognitive Factors:</span> ' . implode(", ", $result['factors']) . '</div>';
        }
        if (isset($result['drift'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Regular Drift:</span> ' . sprintf("%.4f", $result['drift']) . '</div>';
        }
        if (isset($result['weighted_drift'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Weighted Drift:</span> ' . sprintf("%.4f", $result['weighted_drift']) . '</div>';
        }
        if (isset($result['initial_key'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Initial Key:</span> [' . implode(", ", $result['initial_key']) . ']</div>';
        }
        if (isset($result['is_valid'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Text Validity:</span> <span class="' . ($result['is_valid'] ? 'valid' : 'suspicious') . '">' . ($result['is_valid'] ? '✓ VALID' : '⚠️ SUSPICIOUS') . '</span></div>';
        }
        if (isset($result['password_verified'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Password Verification:</span> <span class="' . ($result['password_verified'] ? 'verified' : 'not-verified') . '">' . ($result['password_verified'] ? '✓ CORRECT' : '✗ INCORRECT') . '</span></div>';
        }
        if (isset($result['block_size'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Block Size:</span> ' . $result['block_size'] . '</div>';
        }
        if (isset($result['num_blocks'])) {
            $html .= '<div class="summary-item"><span class="summary-label">Number of Blocks:</span> ' . $result['num_blocks'] . '</div>';
        }
        
        $html .= '</div></div></div>';
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
     * Browser explanation
     */
    private function displayBrowserExplanation() {
        $html = '<div class="explanation-container">';
        $html .= '<div class="explanation-header">COGNITIVE METAMORPHIC CIPHER - EXPLANATION</div>';
        
        $html .= '<div class="developer-info">';
        $html .= '<div class="info-item"><strong>Developed By:</strong> ' . htmlspecialchars($this->developerName) . '</div>';
        $html .= '<div class="info-item"><strong>Student ID:</strong> ' . htmlspecialchars($this->studentID) . '</div>';
        $html .= '<div class="info-item"><strong>Version:</strong> ' . htmlspecialchars($this->projectVersion) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="features-section">';
        $html .= '<div class="section-title">Improved Features:</div>';
        $html .= '<ul class="features-list">';
        $html .= '<li>Enhanced Password Verification System</li>';
        $html .= '<li>Professional Browser Interface</li>';
        $html .= '<li>Improved Verification Code Generation</li>';
        $html .= '<li>Input Cleaning to Prevent Issues</li>';
        $html .= '<li>Clear Error Messages</li>';
        $html .= '</ul>';
        $html .= '</div>';
        
        $html .= '<div class="usage-section">';
        $html .= '<div class="section-title">How to Use:</div>';
        $html .= '<div class="usage-subsection">';
        $html .= '<div class="subsection-title">1. During Encryption:</div>';
        $html .= '<ul>';
        $html .= '<li>Enter plaintext, password, 3 cognitive factors, block size</li>';
        $html .= '<li>System stores verification data automatically</li>';
        $html .= '</ul>';
        $html .= '</div>';
        
        $html .= '<div class="usage-subsection">';
        $html .= '<div class="subsection-title">2. During Decryption:</div>';
        $html .= '<ul>';
        $html .= '<li>Enter HEX string, EXACT password, EXACT factors, EXACT block size</li>';
        $html .= '<li>System verifies password automatically</li>';
        $html .= '<li>Wrong password shows clear error message</li>';
        $html .= '</ul>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '<div class="important-notes">';
        $html .= '<div class="section-title">Important Notes:</div>';
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
                    return $this->displayBrowserInterface($result['error'], 'error');
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
                        return $this->displayBrowserInterface('Invalid hex string!', 'error');
                    }
                } catch (Exception $e) {
                    return $this->displayBrowserInterface('Invalid hex string format!', 'error');
                }
                
                $result = $this->decrypt($ciphertext, $password, $factors, $blockSize, $hexString);
                
                if (isset($result['error'])) {
                    return $this->displayBrowserInterface($result['error'], 'error');
                }
                
                if (!$result['password_verified']) {
                    return $this->displayBrowserInterface('Password verification failed! Please enter the exact password used during encryption.', 'error');
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
                    return $this->displayBrowserInterface($saveResult['message'], 'success');
                } else {
                    return $this->displayBrowserInterface($saveResult['message'], 'error');
                }
                
            case 'clear_verification':
                $message = $this->clearVerificationFile();
                return $this->displayBrowserInterface($message, 'info');
                
            case 'explanation':
                return $this->displayBrowserExplanation();
        }
        
        return $this->displayBrowserInterface();
    }

    /**
     * Display browser interface
     */
    private function displayBrowserInterface($message = '', $messageType = '') {
        $html = $this->getBrowserHeader();
        
        if ($message) {
            $html .= '<div class="message ' . $messageType . '">' . htmlspecialchars($message) . '</div>';
        }
        
        $html .= '<div class="main-content">';
        $html .= '<div class="tabs">';
        $html .= '<button class="tab-button active" onclick="switchTab(\'encrypt\')">🔒 Encrypt Message</button>';
        $html .= '<button class="tab-button" onclick="switchTab(\'decrypt\')">🔓 Decrypt Message</button>';
        $html .= '<button class="tab-button" onclick="switchTab(\'explanation\')">📖 Algorithm Explanation</button>';
        $html .= '<button class="tab-button" onclick="switchTab(\'tools\')">🛠️ Tools</button>';
        $html .= '</div>';
        
        $html .= '<div class="tab-content">';
        
        // Encryption Tab
        $html .= '<div id="encrypt-tab" class="tab-pane active">';
        $html .= '<form method="POST" class="cipher-form">';
        $html .= '<input type="hidden" name="action" value="encrypt">';
        $html .= '<div class="form-group">';
        $html .= '<label for="plaintext">Text to Encrypt:</label>';
        $html .= '<textarea id="plaintext" name="plaintext" rows="3" required placeholder="Enter your secret message here..."></textarea>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="password">Password (case-sensitive):</label>';
        $html .= '<input type="password" id="password" name="password" required placeholder="Enter a strong password">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="factors">Cognitive Factors (3 values, 0-1, e.g., 0.25,0.50,0.75):</label>';
        $html .= '<input type="text" id="factors" name="factors" required placeholder="Memory, Adaptibility, Attention">';
        $html .= '<small class="form-help">Enter exactly 3 comma-separated values between 0 and 1</small>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="block_size">Block Size (integer ≥ 1):</label>';
        $html .= '<input type="number" id="block_size" name="block_size" min="1" value="4" required>';
        $html .= '</div>';
        $html .= '<button type="submit" class="submit-btn encrypt-btn">🔒 Encrypt Message</button>';
        $html .= '</form>';
        $html .= '</div>';
        
        // Decryption Tab
        $html .= '<div id="decrypt-tab" class="tab-pane">';
        $html .= '<form method="POST" class="cipher-form">';
        $html .= '<input type="hidden" name="action" value="decrypt">';
        $html .= '<div class="form-group">';
        $html .= '<label for="hex_string">HEX String:</label>';
        $html .= '<textarea id="hex_string" name="hex_string" rows="2" required placeholder="Enter the hex ciphertext..."></textarea>';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="password_decrypt">Password (EXACT, case-sensitive):</label>';
        $html .= '<input type="password" id="password_decrypt" name="password" required placeholder="Enter the exact password">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="factors_decrypt">Cognitive Factors (EXACT 3 values):</label>';
        $html .= '<input type="text" id="factors_decrypt" name="factors" required placeholder="Must match encryption exactly">';
        $html .= '</div>';
        $html .= '<div class="form-group">';
        $html .= '<label for="block_size_decrypt">Block Size (MUST match encryption):</label>';
        $html .= '<input type="number" id="block_size_decrypt" name="block_size" min="1" required>';
        $html .= '</div>';
        $html .= '<button type="submit" class="submit-btn decrypt-btn">🔓 Decrypt Message</button>';
        $html .= '</form>';
        $html .= '</div>';
        
        // Explanation Tab
        $html .= '<div id="explanation-tab" class="tab-pane">';
        $html .= $this->displayBrowserExplanation();
        $html .= '</div>';
        
        // Tools Tab
        $html .= '<div id="tools-tab" class="tab-pane">';
        $html .= '<div class="tools-container">';
        $html .= '<div class="tool-card">';
        $html .= '<h3>🛠️ Clear Verification Data</h3>';
        $html .= '<p>Clear all stored password verification data.</p>';
        $html .= '<form method="POST" class="tool-form">';
        $html .= '<input type="hidden" name="action" value="clear_verification">';
        $html .= '<button type="submit" class="tool-btn warning-btn" onclick="return confirm(\'Are you sure you want to clear ALL verification data?\')">🗑️ Clear Verification File</button>';
        $html .= '</form>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        $html .= '</div></div>';
        $html .= $this->getBrowserFooter();
        
        return $html;
    }

    /**
     * Display browser result
     */
    private function displayBrowserResult($result, $type) {
        $html = $this->getBrowserHeader();
        
        $html .= '<div class="result-container">';
        
        if ($type === 'encrypt') {
            $html .= '<div class="result-header success">';
            $html .= '<h2>🔒 Encryption Complete!</h2>';
            $html .= '</div>';
            
            $html .= '<div class="result-details">';
            $html .= '<div class="result-card">';
            $html .= '<h3>Encryption Results</h3>';
            $html .= '<div class="result-item"><label>Original Text:</label> <span class="value">' . htmlspecialchars($result['plaintext']) . '</span></div>';
            $html .= '<div class="result-item"><label>Block Size:</label> <span class="value">' . $result['block_size'] . '</span></div>';
            $html .= '<div class="result-item"><label>Weighted Drift:</label> <span class="value">' . sprintf("%.4f", $result['weighted_drift']) . '</span></div>';
            $html .= '<div class="result-item"><label>Number of Blocks:</label> <span class="value">' . $result['num_blocks'] . '</span></div>';
            $html .= '<div class="result-item"><label>Ciphertext (HEX):</label> <span class="value hex-string">' . $result['hex_string'] . '</span></div>';
            $html .= '</div>';
            
            $html .= '<div class="result-actions">';
            $html .= '<button onclick="copyToClipboard(\'' . $result['hex_string'] . '\')" class="action-btn copy-btn">📋 Copy HEX</button>';
            
            $html .= '<form method="POST" style="display: inline;">';
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
            $html .= '<button type="submit" class="action-btn save-btn">💾 Save Details</button>';
            $html .= '</form>';
            
            $html .= '<button onclick="showAnalysis()" class="action-btn analysis-btn">📊 Show Analysis</button>';
            $html .= '</div>';
            
            $html .= '<div id="analysis-section" style="display: none; margin-top: 20px;">';
            $html .= $this->displayBrowserAnalysis($result);
            $html .= '</div>';
        } else {
            $html .= '<div class="result-header ' . ($result['is_valid'] ? 'success' : 'warning') . '">';
            $html .= '<h2>' . ($result['is_valid'] ? '🔓 Decryption Successful!' : '⚠️ Decryption Warning') . '</h2>';
            $html .= '</div>';
            
            $html .= '<div class="result-details">';
            $html .= '<div class="result-card">';
            $html .= '<h3>Decryption Results</h3>';
            $html .= '<div class="result-item"><label>Ciphertext (HEX):</label> <span class="value hex-string">' . $result['hex_string'] . '</span></div>';
            $html .= '<div class="result-item"><label>Block Size:</label> <span class="value">' . $result['block_size'] . '</span></div>';
            $html .= '<div class="result-item"><label>Weighted Drift:</label> <span class="value">' . sprintf("%.4f", $result['weighted_drift']) . '</span></div>';
            $html .= '<div class="result-item"><label>Password Verified:</label> <span class="value ' . ($result['password_verified'] ? 'verified' : 'not-verified') . '">' . ($result['password_verified'] ? '✓ YES' : '✗ NO') . '</span></div>';
            $html .= '<div class="result-item"><label>Recovered Text:</label> <span class="value recovered-text">' . htmlspecialchars($result['plaintext']) . '</span></div>';
            $html .= '<div class="result-item"><label>Text Validity:</label> <span class="value ' . ($result['is_valid'] ? 'valid' : 'suspicious') . '">' . ($result['is_valid'] ? '✓ VALID' : '⚠️ SUSPICIOUS') . '</span></div>';
            $html .= '</div>';
            
            $html .= '<div class="result-actions">';
            $html .= '<button onclick="copyToClipboard(\'' . htmlspecialchars($result['plaintext']) . '\')" class="action-btn copy-btn">📋 Copy Text</button>';
            $html .= '<button onclick="showAnalysis()" class="action-btn analysis-btn">📊 Show Analysis</button>';
            $html .= '</div>';
            
            $html .= '<div id="analysis-section" style="display: none; margin-top: 20px;">';
            $html .= $this->displayBrowserAnalysis($result);
            $html .= '</div>';
        }
        
        $html .= '<div class="navigation">';
        $html .= '<a href="?" class="nav-btn">← Back to Main</a>';
        $html .= '</div>';
        
        $html .= '</div>';
        $html .= $this->getBrowserFooter();
        
        return $html;
    }

    /**
     * Get browser header with CSS - PROFESSIONAL ANIMATED THEME
     */
    private function getBrowserHeader() {
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cognitive Metamorphic Cipher System</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
            <style>
                :root {
                    --bg-0: #070b14;
                    --bg-1: #0d1424;
                    --surface: rgba(255, 255, 255, 0.045);
                    --surface-2: rgba(255, 255, 255, 0.07);
                    --border: rgba(148, 163, 184, 0.18);
                    --text: #e6edf7;
                    --muted: #94a3b8;
                    --primary: #6366f1;
                    --primary-2: #22d3ee;
                    --accent: #f5b942;
                    --success: #10b981;
                    --danger: #ef4444;
                    --warning: #f59e0b;
                    --info: #38bdf8;
                    --radius: 16px;
                    --mono: "JetBrains Mono", "Courier New", monospace;
                }

                * { margin: 0; padding: 0; box-sizing: border-box; }

                html { scroll-behavior: smooth; }

                body {
                    font-family: "Inter", "Segoe UI", Tahoma, sans-serif;
                    background: var(--bg-0);
                    color: var(--text);
                    min-height: 100vh;
                    padding: 24px;
                    position: relative;
                    overflow-x: hidden;
                    line-height: 1.55;
                }

                /* ===== Animated background ===== */
                body::before,
                body::after {
                    content: "";
                    position: fixed;
                    width: 620px;
                    height: 620px;
                    border-radius: 50%;
                    filter: blur(110px);
                    opacity: 0.35;
                    z-index: 0;
                    pointer-events: none;
                }
                body::before {
                    background: var(--primary);
                    top: -180px;
                    left: -160px;
                    animation: floatA 18s ease-in-out infinite alternate;
                }
                body::after {
                    background: var(--primary-2);
                    bottom: -200px;
                    right: -160px;
                    animation: floatB 22s ease-in-out infinite alternate;
                }
                @keyframes floatA {
                    0%   { transform: translate(0, 0) scale(1); }
                    100% { transform: translate(180px, 120px) scale(1.25); }
                }
                @keyframes floatB {
                    0%   { transform: translate(0, 0) scale(1.1); }
                    100% { transform: translate(-200px, -100px) scale(0.9); }
                }

                .container {
                    position: relative;
                    z-index: 1;
                    max-width: 1180px;
                    margin: 0 auto;
                    background: linear-gradient(180deg, rgba(17, 25, 45, 0.82), rgba(10, 16, 30, 0.88));
                    backdrop-filter: blur(18px);
                    -webkit-backdrop-filter: blur(18px);
                    border-radius: 24px;
                    border: 1px solid var(--border);
                    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.06);
                    overflow: hidden;
                    animation: containerIn 0.9s cubic-bezier(.2,.8,.2,1) both;
                }
                @keyframes containerIn {
                    from { opacity: 0; transform: translateY(30px) scale(0.98); }
                    to   { opacity: 1; transform: translateY(0) scale(1); }
                }

                /* ===== Banner ===== */
                .banner-container {
                    position: relative;
                    padding: 44px 32px 32px;
                    text-align: center;
                    background:
                        radial-gradient(circle at 20% 0%, rgba(99, 102, 241, 0.35), transparent 55%),
                        radial-gradient(circle at 85% 100%, rgba(34, 211, 238, 0.25), transparent 55%),
                        linear-gradient(135deg, #0f1a33, #121c3a);
                    border-bottom: 1px solid var(--border);
                    overflow: hidden;
                }
                .banner-container::before {
                    content: "";
                    position: absolute;
                    inset: 0;
                    background-image:
                        linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                        linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
                    background-size: 42px 42px;
                    animation: gridMove 24s linear infinite;
                    mask-image: radial-gradient(circle at center, #000 30%, transparent 80%);
                    -webkit-mask-image: radial-gradient(circle at center, #000 30%, transparent 80%);
                }
                @keyframes gridMove {
                    from { background-position: 0 0, 0 0; }
                    to   { background-position: 42px 42px, 42px 42px; }
                }
                .banner-header, .banner-info { position: relative; z-index: 1; }

                .banner-title {
                    font-size: clamp(1.6em, 4vw, 2.7em);
                    font-weight: 800;
                    letter-spacing: 0.5px;
                    background: linear-gradient(90deg, #ffffff, #a5b4fc, #67e8f9, #ffffff);
                    background-size: 250% auto;
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                    animation: shine 6s linear infinite;
                    margin-bottom: 10px;
                }
                @keyframes shine {
                    to { background-position: 250% center; }
                }
                .banner-subtitle {
                    font-size: 1.05em;
                    color: var(--muted);
                    font-weight: 400;
                    letter-spacing: 3px;
                    text-transform: uppercase;
                    animation: fadeUp 1s 0.2s both;
                }

                .banner-info {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                    gap: 14px;
                    margin-top: 28px;
                    padding: 18px 22px;
                    background: rgba(7, 11, 20, 0.55);
                    border-radius: 14px;
                    border: 1px solid var(--border);
                    text-align: left;
                    animation: fadeUp 1s 0.35s both;
                }
                .info-row {
                    display: flex;
                    justify-content: space-between;
                    gap: 12px;
                    padding: 8px 0;
                    border-bottom: 1px dashed rgba(148, 163, 184, 0.18);
                    font-size: 0.93em;
                }
                .info-label { font-weight: 600; color: var(--accent); }
                .info-value { color: var(--text); font-weight: 500; text-align: right; }

                /* ===== Main + Tabs ===== */
                .main-content { padding: 32px; }

                .tabs {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                    margin-bottom: 30px;
                    padding: 6px;
                    background: rgba(7, 11, 20, 0.55);
                    border: 1px solid var(--border);
                    border-radius: 14px;
                }
                .tab-button {
                    flex: 1;
                    min-width: 160px;
                    padding: 12px 20px;
                    background: transparent;
                    border: none;
                    border-radius: 10px;
                    color: var(--muted);
                    font-family: inherit;
                    font-size: 0.97em;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    position: relative;
                    overflow: hidden;
                }
                .tab-button:hover {
                    color: var(--text);
                    background: var(--surface-2);
                    transform: translateY(-1px);
                }
                .tab-button.active {
                    color: #fff;
                    background: linear-gradient(135deg, var(--primary), #4f46e5 55%, #0ea5c6);
                    box-shadow: 0 8px 22px rgba(99, 102, 241, 0.45);
                }

                .tab-pane { display: none; }
                .tab-pane.active { display: block; animation: fadeUp 0.55s cubic-bezier(.2,.8,.2,1) both; }

                @keyframes fadeUp {
                    from { opacity: 0; transform: translateY(16px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to   { opacity: 1; }
                }

                /* ===== Forms ===== */
                .cipher-form {
                    max-width: 800px;
                    margin: 0 auto;
                    background: var(--surface);
                    padding: 34px;
                    border-radius: 18px;
                    border: 1px solid var(--border);
                    box-shadow: 0 14px 40px rgba(0, 0, 0, 0.3);
                    position: relative;
                }
                .cipher-form::before {
                    content: "";
                    position: absolute;
                    top: 0; left: 24px; right: 24px;
                    height: 2px;
                    background: linear-gradient(90deg, transparent, var(--primary-2), var(--primary), transparent);
                    background-size: 200% 100%;
                    animation: slideBar 4s linear infinite;
                }
                @keyframes slideBar {
                    from { background-position: 200% 0; }
                    to   { background-position: -200% 0; }
                }

                .form-group { margin-bottom: 22px; }
                .form-group label {
                    display: block;
                    margin-bottom: 8px;
                    font-weight: 600;
                    color: #c7d2fe;
                    font-size: 0.95em;
                    letter-spacing: 0.3px;
                }
                .form-group input[type="text"],
                .form-group input[type="password"],
                .form-group input[type="number"],
                .form-group textarea {
                    width: 100%;
                    padding: 14px 16px;
                    background: rgba(7, 11, 20, 0.6);
                    border: 1px solid var(--border);
                    border-radius: 12px;
                    color: var(--text);
                    font-family: inherit;
                    font-size: 1em;
                    transition: all 0.3s ease;
                }
                .form-group input::placeholder,
                .form-group textarea::placeholder { color: #5b6b85; }
                .form-group textarea { min-height: 100px; resize: vertical; }
                .form-group input:focus,
                .form-group textarea:focus {
                    outline: none;
                    border-color: var(--primary);
                    background: rgba(7, 11, 20, 0.85);
                    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2), 0 0 24px rgba(34, 211, 238, 0.12);
                }
                .form-help { display: block; margin-top: 6px; color: var(--muted); font-size: 0.85em; }

                .submit-btn {
                    position: relative;
                    overflow: hidden;
                    width: 100%;
                    padding: 16px;
                    border: none;
                    border-radius: 12px;
                    font-family: inherit;
                    font-size: 1.02em;
                    font-weight: 700;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    text-transform: uppercase;
                    letter-spacing: 1.5px;
                    margin-top: 8px;
                    color: #fff;
                }
                .submit-btn::after {
                    content: "";
                    position: absolute;
                    top: 0; left: -80%;
                    width: 50%; height: 100%;
                    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
                    transform: skewX(-20deg);
                    transition: left 0.7s ease;
                }
                .submit-btn:hover::after { left: 130%; }
                .encrypt-btn {
                    background: linear-gradient(135deg, #4f46e5, #06b6d4);
                    box-shadow: 0 10px 26px rgba(79, 70, 229, 0.4);
                }
                .decrypt-btn {
                    background: linear-gradient(135deg, #0d9488, #10b981);
                    box-shadow: 0 10px 26px rgba(16, 185, 129, 0.35);
                }
                .submit-btn:hover { transform: translateY(-3px); filter: brightness(1.08); }
                .submit-btn:active { transform: translateY(-1px); }

                /* ===== Messages ===== */
                .message {
                    padding: 14px 24px;
                    margin: 22px auto 0;
                    border-radius: 12px;
                    max-width: 800px;
                    font-weight: 600;
                    text-align: center;
                    border: 1px solid;
                    animation: slideIn 0.5s ease;
                }
                @keyframes slideIn {
                    from { opacity: 0; transform: translateY(-14px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                .message.success { background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.5); color: #6ee7b7; }
                .message.error   { background: rgba(239, 68, 68, 0.12);  border-color: rgba(239, 68, 68, 0.5);  color: #fca5a5; animation: slideIn 0.5s ease, shake 0.5s 0.1s; }
                .message.info    { background: rgba(56, 189, 248, 0.12); border-color: rgba(56, 189, 248, 0.5); color: #7dd3fc; }
                @keyframes shake {
                    0%,100% { transform: translateX(0); }
                    25% { transform: translateX(-6px); }
                    75% { transform: translateX(6px); }
                }

                /* ===== Results ===== */
                .result-container { max-width: 1000px; margin: 0 auto; padding: 32px; animation: fadeUp 0.7s ease both; }

                .result-header {
                    padding: 28px;
                    border-radius: 18px;
                    margin-bottom: 26px;
                    text-align: center;
                    background: linear-gradient(135deg, #4f46e5, #7c3aed);
                    box-shadow: 0 14px 34px rgba(79, 70, 229, 0.35);
                    position: relative;
                    overflow: hidden;
                }
                .result-header::after {
                    content: "";
                    position: absolute;
                    top: 0; left: -60%;
                    width: 40%; height: 100%;
                    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.25), transparent);
                    transform: skewX(-20deg);
                    animation: sweep 3.5s ease-in-out infinite;
                }
                @keyframes sweep { 0% { left: -60%; } 60%,100% { left: 140%; } }
                .result-header.success { background: linear-gradient(135deg, #0f766e, #10b981); box-shadow: 0 14px 34px rgba(16, 185, 129, 0.3); }
                .result-header.warning { background: linear-gradient(135deg, #b45309, #f59e0b); box-shadow: 0 14px 34px rgba(245, 158, 11, 0.3); }
                .result-header h2 { font-size: 2em; color: #fff; position: relative; z-index: 1; }

                .result-details {
                    background: var(--surface);
                    border-radius: 18px;
                    padding: 30px;
                    border: 1px solid var(--border);
                    box-shadow: 0 14px 40px rgba(0, 0, 0, 0.3);
                }
                .result-card { margin-bottom: 24px; }
                .result-card h3 {
                    color: var(--primary-2);
                    margin-bottom: 18px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid var(--border);
                    font-weight: 700;
                }
                .result-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 16px;
                    padding: 12px 8px;
                    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
                    border-radius: 8px;
                    transition: background 0.25s ease;
                    animation: fadeUp 0.6s both;
                }
                .result-item:nth-child(2) { animation-delay: 0.05s; }
                .result-item:nth-child(3) { animation-delay: 0.1s; }
                .result-item:nth-child(4) { animation-delay: 0.15s; }
                .result-item:nth-child(5) { animation-delay: 0.2s; }
                .result-item:nth-child(6) { animation-delay: 0.25s; }
                .result-item:nth-child(7) { animation-delay: 0.3s; }
                .result-item:hover { background: var(--surface-2); }
                .result-item label { font-weight: 600; color: var(--muted); white-space: nowrap; }
                .result-item .value {
                    font-family: var(--mono);
                    font-size: 0.98em;
                    word-break: break-all;
                    text-align: right;
                    max-width: 65%;
                }
                .result-item .hex-string { color: var(--primary-2); font-weight: 600; }
                .result-item .recovered-text { color: var(--accent); font-weight: 600; }
                .result-item .verified, .result-item .valid { color: #34d399; font-weight: 700; }
                .result-item .not-verified { color: #f87171; font-weight: 700; }
                .result-item .suspicious { color: #fbbf24; font-weight: 700; }

                .result-actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 26px; }
                .action-btn {
                    padding: 12px 22px;
                    border: 1px solid var(--border);
                    border-radius: 10px;
                    font-family: inherit;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    color: #fff;
                    background: var(--surface-2);
                }
                .copy-btn     { background: linear-gradient(135deg, #2563eb, #38bdf8); border-color: transparent; }
                .save-btn     { background: linear-gradient(135deg, #7c3aed, #a78bfa); border-color: transparent; }
                .analysis-btn { background: linear-gradient(135deg, #d97706, #f5b942); border-color: transparent; color: #1b1405; }
                .action-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(0, 0, 0, 0.4); }

                .navigation { margin-top: 28px; text-align: center; }
                .nav-btn {
                    display: inline-block;
                    padding: 12px 30px;
                    background: var(--surface-2);
                    color: var(--text);
                    text-decoration: none;
                    border-radius: 10px;
                    font-weight: 600;
                    border: 1px solid var(--border);
                    transition: all 0.3s ease;
                }
                .nav-btn:hover {
                    background: linear-gradient(135deg, var(--primary), #0ea5c6);
                    border-color: transparent;
                    transform: translateX(-4px);
                    box-shadow: 0 10px 24px rgba(99, 102, 241, 0.4);
                }

                /* ===== Tools ===== */
                .tools-container { display: grid; gap: 20px; margin-top: 10px; }
                .tool-card {
                    background: var(--surface);
                    padding: 26px;
                    border-radius: 16px;
                    border: 1px solid var(--border);
                    transition: all 0.3s ease;
                }
                .tool-card:hover { transform: translateY(-4px); border-color: rgba(99, 102, 241, 0.5); box-shadow: 0 14px 34px rgba(0, 0, 0, 0.35); }
                .tool-card h3 { color: var(--accent); margin-bottom: 8px; }
                .tool-card p { color: var(--muted); margin-bottom: 18px; }
                .tool-btn {
                    padding: 12px 24px;
                    border: none;
                    border-radius: 10px;
                    font-family: inherit;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    color: #fff;
                }
                .warning-btn { background: linear-gradient(135deg, #dc2626, #f97316); }
                .tool-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(220, 38, 38, 0.4); }

                /* ===== Explanation / Analysis ===== */
                .explanation-container,
                .analysis-container {
                    background: var(--surface);
                    border-radius: 18px;
                    padding: 32px;
                    border: 1px solid var(--border);
                    box-shadow: 0 14px 40px rgba(0, 0, 0, 0.3);
                    margin-top: 10px;
                }
                .explanation-header,
                .analysis-header {
                    font-size: 1.7em;
                    font-weight: 800;
                    background: linear-gradient(90deg, #a5b4fc, #67e8f9);
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                    margin-bottom: 22px;
                    text-align: center;
                }
                .developer-info {
                    background: rgba(7, 11, 20, 0.55);
                    padding: 20px;
                    border-radius: 12px;
                    margin-bottom: 26px;
                    border: 1px solid var(--border);
                }
                .info-item { margin-bottom: 8px; display: flex; gap: 10px; }
                .info-item strong { color: var(--accent); }

                .features-section, .usage-section, .important-notes { margin-bottom: 28px; }
                .section-title {
                    font-size: 1.25em;
                    font-weight: 700;
                    color: var(--primary-2);
                    margin-bottom: 14px;
                    padding-bottom: 8px;
                    border-bottom: 1px solid var(--border);
                }
                .features-list, .usage-section ul, .important-notes ul { list-style: none; padding-left: 0; }
                .features-list li, .usage-section ul li, .important-notes ul li {
                    padding: 10px 12px;
                    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
                    color: var(--text);
                    transition: all 0.25s ease;
                    border-radius: 8px;
                }
                .features-list li:hover, .usage-section ul li:hover, .important-notes ul li:hover {
                    background: var(--surface-2);
                    padding-left: 18px;
                }
                .features-list li:before { content: "✓"; color: var(--success); margin-right: 10px; font-weight: bold; }
                .usage-subsection { margin-bottom: 18px; }
                .subsection-title { font-size: 1.05em; font-weight: 600; color: var(--accent); margin-bottom: 8px; }

                .history-section, .summary-section { margin-bottom: 24px; }
                .history-list {
                    background: rgba(7, 11, 20, 0.7);
                    border-radius: 12px;
                    padding: 12px;
                    max-height: 320px;
                    overflow-y: auto;
                    border: 1px solid var(--border);
                }
                .history-list::-webkit-scrollbar { width: 8px; }
                .history-list::-webkit-scrollbar-thumb { background: rgba(99, 102, 241, 0.5); border-radius: 8px; }
                .history-item {
                    padding: 7px 12px;
                    border-bottom: 1px solid rgba(148, 163, 184, 0.08);
                    font-family: var(--mono);
                    font-size: 0.86em;
                    color: #cbd5e1;
                }
                .history-item:last-child { border-bottom: none; }
                .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px; }
                .summary-item {
                    background: rgba(7, 11, 20, 0.55);
                    padding: 12px 16px;
                    border-radius: 10px;
                    border: 1px solid var(--border);
                    transition: all 0.3s ease;
                }
                .summary-item:hover { border-color: rgba(34, 211, 238, 0.5); transform: translateY(-2px); }
                .summary-label { font-weight: 600; color: var(--accent); margin-right: 8px; }
                .summary-item .valid, .summary-item .verified { color: #34d399; font-weight: 700; }
                .summary-item .suspicious { color: #fbbf24; font-weight: 700; }
                .summary-item .not-verified { color: #f87171; font-weight: 700; }

                .footer {
                    text-align: center;
                    padding: 24px;
                    color: var(--muted);
                    font-size: 0.88em;
                    border-top: 1px solid var(--border);
                    background: rgba(7, 11, 20, 0.5);
                }

                @media (max-width: 768px) {
                    body { padding: 12px; }
                    .main-content, .result-container { padding: 18px; }
                    .cipher-form { padding: 22px; }
                    .tabs { flex-direction: column; }
                    .tab-button { width: 100%; }
                    .result-item { flex-direction: column; align-items: flex-start; gap: 4px; }
                    .result-item .value { max-width: 100%; text-align: left; }
                    .result-actions { flex-direction: column; }
                    .action-btn { justify-content: center; }
                }

                @media (prefers-reduced-motion: reduce) {
                    *, *::before, *::after { animation: none !important; transition: none !important; }
                }
            </style>
            <script>
                function switchTab(tabName) {
                    document.querySelectorAll(".tab-pane").forEach(function(tab) {
                        tab.classList.remove("active");
                    });
                    document.querySelectorAll(".tab-button").forEach(function(btn) {
                        btn.classList.remove("active");
                        var oc = btn.getAttribute("onclick") || "";
                        if (oc.indexOf(tabName) !== -1) {
                            btn.classList.add("active");
                        }
                    });
                    var pane = document.getElementById(tabName + "-tab");
                    if (pane) { pane.classList.add("active"); }
                }

                function copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(function() {
                        alert("Copied to clipboard!");
                    }).catch(function(err) {
                        console.error("Failed to copy: ", err);
                    });
                }

                function showAnalysis() {
                    var section = document.getElementById("analysis-section");
                    var btn = document.querySelector(".analysis-btn");
                    if (!section) { return; }
                    if (section.style.display === "none") {
                        section.style.display = "block";
                        section.style.animation = "fadeUp 0.5s ease both";
                        if (btn) { btn.textContent = "📊 Hide Analysis"; }
                    } else {
                        section.style.display = "none";
                        if (btn) { btn.textContent = "📊 Show Analysis"; }
                    }
                }

                document.addEventListener("DOMContentLoaded", function() {
                    if (document.getElementById("encrypt-tab")) {
                        switchTab("encrypt");
                    }
                });
            </script>
        </head>
        <body>
        <div class="container">';

        $html .= $this->displayBrowserBanner();
        return $html;
    }

    /**
     * Get browser footer
     */
    private function getBrowserFooter() {
        $html = '
            <div class="footer">
                <p>© 2026 Cognitive Metamorphic Cipher System | Version ' . $this->projectVersion . '</p>
                <p>Developed by ' . htmlspecialchars($this->developerName) . ' | ' . htmlspecialchars($this->studentID) . '</p>
                <p>' . htmlspecialchars($this->university) . '</p>
            </div>
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
