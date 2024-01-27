# Deeply Nested Structure Generator

This repository hosts a collection of PHP tools adept at crafting and evaluating the performance of deeply nested curly regex patterns. It includes facilities for constructing nested regex expressions, gauging the performance repercussions of executing these regex patterns, and generating intricately nested JavaScript functions as test subjects for the regex.

The methodology employs a form of synthetic recursion within regex patterns, a necessary approach since regex engines typically lack genuine recursion capabilities or stack-based memory. This limitation makes the task of matching structures with arbitrary levels of nesting particularly challenging.

Below is an illustration of how layers are added to create increasingly complex nested structures:
```php
{[^{}]*} < One layer
{(?:[^{}]|{[^{}]*})*} < Two layers
{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*} < Three layers
{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*})*} < Four layers
{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{(?:[^{}]|{[^{}]*})*})*})*})*} < Five layers
```
```
{((?:[^{}]|{(?:[^{}]|{[^{}]*})*})*?)}
```
The basic element of the structure is explained as follows:
```php
{: An opening curly brace.
(?:[^{}]|{[^{}]*})*: A non-capturing group that matches:
    [^{}]: Any character that is not a curly brace.
    |: OR
    {[^{}]*}: A pair of curly braces containing any characters that are not curly braces (no nesting).
}: A closing curly brace.
```
Through these tools and the outlined method, users can create and examine the intricacies and performance implications of regex patterns dealing with deeply nested structures.
Please note: This recursive regex function is more for testing than for use. 
I have issues with it personally, other than when using the base version

## generateNestedJS

A JavaScript function that generates a function with a deeply nested structure, incorporating various control structures like if, while, do, and foreach.

### Usage 
```php
$testString = generateNestedJS(200);
```

## generateNestedRegex

A PHP function designed to craft regex patterns featuring user-defined levels of nested curly braces.

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

## Performance Visualizations

This study, conducted using preg_match_all on PHP 8.3, explores the relationship between the depth of nested structures in functions and regex patterns, and their impact on processing times.

Key findings include:

 - Performance Dynamics: When regex complexity exceeds that of function layers, processing tends to be quicker. Conversely, a higher count of function layers paired with fewer regex layers results in slower processing times.
 - Optimal Layer Ratio: Interestingly, regex processing speeds up with more recursive layers, especially noticeable with a high count of function layers.
 - Limitation Observed: Beyond 62 layers, regex matching ceased, indicated by a compilation error due to excessively nested parentheses.


### 100-Layer Function vs. 40-Layer Regex (50 iterations):
![3GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/00790b21-6db3-4dd1-a15c-845d19d5f664)


### 40-Layer Function vs. 50-Layer Regex (50 iterations):
![0GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/b2060ffd-d82c-4f72-860b-eb39769fd736)


This demonstrates that it slopes off near the end, when there are more regex layers than function layers.

### 400-Layer Function vs. 50-Layer Regex (50 iterations):
![1GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/54150cd3-1e6d-47ea-b042-a5a0c17814f4)


This demonstrates that only having two layers of regex but a large quantity of function layers, takes up a LOT of time.

### 200-Layer Function vs. 50-Layer Regex (50 iterations):
![5GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/fcbb5d3e-f04f-4b25-a442-cfd3a9a2459c)


### 2000-Layer Function vs. 50-Layer Regex (50 iterations):
![6GITCapture](https://github.com/dehlirious/regexFun/assets/25449483/abbb31ed-37a7-4491-b2a6-cefa9889169f)

The visual aids aim to provide a clearer understanding of the dynamics.

Consider these insights carefully when working with nested structures in regex and functions.
