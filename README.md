# Deeply Nested Structure Generator

This repository contains a set of PHP and JavaScript tools designed for generating and measuring the performance of a deeply nested curly regex I use. Tools for creating nested regex patterns, measuring the performance impact of regex execution, and generating deeply nested JavaScript functions to test the regex with.

Used to match nested curly's
```php
{[^{}]*} < One layer
{(?:[^{}]|{[^{}]*})*} < Two layers
{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*} < Three layers
{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*})*} < Four layers
{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*})*})*} < Five layers
```

## generateNestedJS

A JavaScript function that generates a function with a deeply nested structure, incorporating various control structures like if, while, do, and foreach.

### Usage 
```php
$testString = generateNestedJS(200);
```

## generateNestedRegex

A PHP function that generates a regex pattern with a specified number of nested curly brace layers.

### Usage

```php
$numberOfAdditionalLayers = 5;
$regexPattern = generateNestedRegex($numberOfAdditionalLayers);
echo $regexPattern;
```

## measureRegexPerformance

A PHP function that measures the performance of regex patterns with increasing layers of nesting. It applies each pattern to a test string, measures the time taken for each, and records the fastest, slowest, and average times.

### Usage
```php
$testString = "your test string here";
$maxLayers = 10;
$iterationsPerLayer = 100;
$performanceTimings = measureRegexPerformance($testString, $maxLayers, $iterationsPerLayer);
foreach ($performanceTimings as $layers => $timing) {
    echo "Layers: $layers, Fastest Time: {$timing['fastest']}s, Slowest Time: {$timing['slowest']}s, Average Time: {$timing['average']}s\n";
}

```

## Results

This was done using preg_match_all, php8.3

Warning: Data may be wrong, who knows. But these were the results.

When there are more regex layers than function layers, it seems to go rather quickly.
The data has roughly shown that more function layers with smaller regex layer counts == slower processing times.
The data also demonstrated that regex finished faster with more recursive layers, when there was a large quantity of function layers.

Note: After 62 layers, it seemed to stop matching.
`preg_match_all(): Compilation failed: parentheses are too deeply nested at offset 2503`

These pictures will only show 50 layers of regex unless otherwise stated.

### 100 layer function, 40 layer regex, 50x times
![3GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/00790b21-6db3-4dd1-a15c-845d19d5f664)


### A 40 layer function, tested at 50 layers of regex, 50x times
![0GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/b2060ffd-d82c-4f72-860b-eb39769fd736)


This demonstrates that it slopes off near the end, when there are more regex layers than function layers.

### A 400 layer function, 50x times
![1GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/54150cd3-1e6d-47ea-b042-a5a0c17814f4)


This demonstrates that only having two layers of regex but a large quantity of function layers, takes up a LOT of time.

### 200 layer function, 50x times
![5GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/fcbb5d3e-f04f-4b25-a442-cfd3a9a2459c)

Overall, do with the data what you can. 

### 2000 layer function, 50x times
![6GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/abbb31ed-37a7-4491-b2a6-cefa9889169f)
