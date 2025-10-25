<?php
// Read routes file and check syntax
$content = file_get_contents('routes/web.php');
echo "=== Routes File Analysis ===\n";
echo "File length: " . strlen($content) . " characters\n\n";

// Count opening and closing braces
$openBraces = substr_count($content, '{');
$closeBraces = substr_count($content, '}');

echo "Opening braces: $openBraces\n";
echo "Closing braces: $closeBraces\n";
echo "Difference: " . ($openBraces - $closeBraces) . "\n\n";

// Find middleware groups
$authGroups = substr_count($content, "Route::middleware(['auth'])->group(function () {");
$authCloses = substr_count($content, "});");

echo "Auth middleware groups: $authGroups\n";
echo "Auth group closes: $authCloses\n";
echo "Auth group difference: " . ($authGroups - $authCloses) . "\n\n";

// Show the problematic area
echo "=== End of file ===\n";
$lines = explode("\n", $content);
$lastLines = array_slice($lines, -10);
foreach ($lastLines as $i => $line) {
    echo ($i + count($lines) - 9) . ": " . trim($line) . "\n";
}

echo "\n=== Fix Suggestion ===\n";
if ($openBraces > $closeBraces) {
    echo "Missing " . ($openBraces - $closeBraces) . " closing brace(s)\n";
    echo "Add }); at the end of the auth middleware group\n";
}
?>
