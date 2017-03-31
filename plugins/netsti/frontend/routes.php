<?php

use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;

App::before(function($request) {
	// $translator = Translator::instance();
	// if (!$translator->isConfigured())
	// 	return;

	// $locale = Request::segment(1);

	// // if (post('locale') && $locale != post('locale')) {
	// // 	$translator->setLocale(post('locale'));
	// // }

	// if (!$locale || !Locale::isValid($locale)) {
	// 	$localeSession = Session::get($translator::SESSION_LOCALE);
	// 	if ($localeSession) {
	// 		$translator->setLocale($localeSession);
	// 	} else {
	// 		$accepted = parseLanguageList('en');
	// 		$available = Locale::listEnabled();
	// 		$matches = findMatches($accepted, $available);
	// 		if (!empty($matches)) {
	// 			$match = array_values($matches)[0];
	// 			$translator->setLocale($match);
	// 		}
	// 	}
	// }

	// $locale = $translator->getLocale();

	// if ($translator->setLocale($locale) === false) {
	// 	$translator->setLocale($translator->getDefaultLocale());
	// }

	// Route::group(['prefix' => $locale], function() {
	// 	Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
	// });

	// Route::any($locale, 'Cms\Classes\CmsController@run');

	// Event::listen('cms.route', function() use ($locale) {
	// 	Route::group(['prefix' => $locale], function() {
	// 		Route::any('{slug}', 'Cms\Classes\CmsController@run')->where('slug', '(.*)?');
	// 	});
	// });

	// Route::get('/', function() use ($locale) {
	// 	return redirect($locale);
	// });
});

function parseLanguageList($languageList) {
	if (is_null($languageList)) {
		if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			return array();
		}
		$languageList = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
	}
	$languages = array();
	$languageRanges = explode(',', trim($languageList));
	foreach ($languageRanges as $languageRange) {
		if (preg_match('/(\*|[a-zA-Z0-9]{1,8}(?:-[a-zA-Z0-9]{1,8})*)(?:\s*;\s*q\s*=\s*(0(?:\.\d{0,3})|1(?:\.0{0,3})))?/', trim($languageRange), $match)) {
			if (!isset($match[2])) {
				$match[2] = '1.0';
			} else {
				$match[2] = (string) floatval($match[2]);
			}
			if (!isset($languages[$match[2]])) {
				$languages[$match[2]] = strtolower($match[1]);
			}
		}
	}
	krsort($languages);
	return $languages;
}

// compare two parsed arrays of language tags and find the matches
function findMatches($accepted, $available) {
	$matches = array();
	$any = false;
	foreach ($accepted as $acceptedQuality => $acceptedValue) {
		$acceptedQuality = floatval($acceptedQuality);
		if ($acceptedQuality === 0.0) continue;
		foreach ($available as $key => $value) {
			if ($acceptedValue === '*') {
				$any = true;
			}
			$matchingGrade = matchLanguage($acceptedValue, $key);
			if ($matchingGrade > 0) {
				$q = (string) ($acceptedQuality * $matchingGrade);
				if (!in_array($q, $matches)) {
					$matches[$q] = $key;
				}
			}
		}
	}
	if (count($matches) === 0 && $any) {
		$matches = $available;
	}
	krsort($matches);
	return $matches;
}

function matchLanguage($a, $b) {
	$b = strtolower($b);
	$a = explode('-', $a);
	$b = explode('-', $b);
	for ($i=0, $n=min(count($a), count($b)); $i<$n; $i++) {
		if ($a[$i] !== $b[$i]) break;
	}

	return $i;
}
