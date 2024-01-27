<?php

// Generates a regex pattern with a specified number of nested layers
function generateNestedRegex($additionalLayers) {
	$basePattern = "{[^{}]*}"; // Base pattern for one layer of nesting
	$recursivePart = "{(?:[^{}]|{[^{}]*})*}"; // Pattern for the recursive part

	// Add additional layers of nesting
	for ($i = 0; $i < $additionalLayers; $i++) {
		// Embed the recursive part within the base pattern
		$basePattern = str_replace("{[^{}]*}", $recursivePart, $basePattern);
	}
	return $basePattern;
}

// Generate a regex pattern with additional layers
$numberOfAdditionalLayers = 15;
$regexPattern = generateNestedRegex($numberOfAdditionalLayers);
echo $regexPattern. "\n\n\n\n\n\n\n<br/>\n";
//Designed for usage in this regex (async\s+)?function\s+(\w+)\s*\(([^)]*)\)\s*{((?:[^{}]|{(?:[^{}]|{[^{}]*})*})*?)}

// Measures the performance of regex patterns with increasing layers of nesting
function measureRegexPerformance($testString, $maxLayers, $iterationsPerLayer) {
	$timings = [];

	for ($layers = 1; $layers <= $maxLayers; $layers++) {
		$regexPattern = generateNestedRegex($layers - 1); // generate pattern with the current number of layers
		$times = [];
		$totalTimeForLayer = 0;
		$totalMatchesForLayer = 0;

		for ($i = 0; $i < $iterationsPerLayer; $i++) {
			$startTime = microtime(true);
			preg_match_all($regexPattern, $testString, $matches);
			$endTime = microtime(true);
			$iterationTime = $endTime - $startTime;
			$times[] = $iterationTime;
			$totalTimeForLayer += $iterationTime;
			$totalMatchesForLayer += count($matches[0]);
			
			if (!isset($totalTimeForLayerx[$i])) {
				$totalTimeForLayerx[$i] = 0;
				$totalMatchesForLayerx[$i] = 0;
			}

			$totalTimeForLayerx[$i] += $iterationTime;
			$totalMatchesForLayerx[$i] += count($matches[0]);
		}

		// Calculate fastest, slowest, and average time
		$fastestTime = min($times);
		$slowestTime = max($times);
		$averageTime = array_sum($times) / count($times);

		$timings[$layers] = [
			'fastest' => $fastestTime,
			'slowest' => $slowestTime,
			'average' => $averageTime,
			'total'   => $totalTimeForLayer,
			'totalx'   => $totalTimeForLayerx,
			'matches' => $totalMatchesForLayer,
			'matchesx' => $totalMatchesForLayerx
		];
	}

	return $timings;
}

// Generate deeply nested JavaScript code
function generateNestedJS($depth) {
	$code = "function deeplyNestedFunction() {\n";
	$indentation = "	";

	// Add nested structures
	for ($i = 0; $i < $depth; $i++) {
		$structure = mt_rand(0, 3); // Randomly choose a structure
		switch ($structure) {
			case 0: $code .= $indentation . "if (1) {\n"; break;
			case 1: $code .= $indentation . "for (let i = 0; i < 10; i++) {\n"; break;
			case 2: $code .= $indentation . "while (0) {\n"; break;
			case 3: $code .= $indentation . "do {\n"; break;
		}
		$indentation .= "	";
	}

	// Close the nested structures
	for ($i = 0; $i < $depth; $i++) {
		$indentation = substr($indentation, 0, -4);
		$structure = mt_rand(0, 3);
		$code .= ($structure == 3) ? $indentation . "} while (condition);\n" : $indentation . "}\n";
	}
	$code .= "}\n";
	return $code;
}

// Measure the time taken to generate the nested JavaScript function
$startTime = microtime(true);
$nestedFunctionString = generateNestedJS(100); // Generate 100 layers of nesting
$endTime = microtime(true);
$generationTime = ($endTime - $startTime);

echo "Nested Function Generation Time: {$generationTime}s \n <br/>\n";

// Configuration for performance measurement
$maxLayers = 50; // Maximum number of layers to test with regex
$iterationsPerLayer = 50; // Number of iterations to test each layer

// Measure the performance of regex matching on the generated nested function
$startTime = microtime(true);
$performanceTimings = measureRegexPerformance($nestedFunctionString, $maxLayers, $iterationsPerLayer);
$endTime = microtime(true);
$measurementTime = ($endTime - $startTime);

echo "Total Measurement Time: {$measurementTime}s \n <br/>\n";

// Display the performance results for each layer
foreach ($performanceTimings as $layers => $timing) {
    // Convert timings to milliseconds for display
    $totalMs = intval($timing['total'] * 1000);
    $fastestMs = intval($timing['fastest'] * 1000);
    $slowestMs = intval($timing['slowest'] * 1000);
    $averageMs = intval($timing['average'] * 1000);
    
    // Retrieve detailed match data (not displayed directly)
    $totalTimes = $timing['totalx'];
    $totalMatches = $timing['matchesx'];

    $totalxMs = intval((array_sum($totalTimes)) * 1000);
    $averageMatches = array_sum($totalMatches) / count($totalMatches);
    
    // Output the timing information
    echo "Layers: $layers, Total Time: {$totalMs}ms, Fastest Time: {$fastestMs}ms, Slowest Time: {$slowestMs}ms, Average Time: {$averageMs}ms, Matches: $averageMatches / {$timing['matches']} <br/>\n";
}

