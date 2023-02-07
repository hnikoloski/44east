<?php

// Register Polylang Strings
pll_register_string('44east', 'Filter by', '44east');
pll_register_string('44east', 'Categories', '44east');
pll_register_string('44east', 'Tag', '44east');
pll_register_string('44east', 'Got more questions?', '44east');
pll_register_string('44east', 'Our detailed FAQ may contain the answer you are seeking.', '44east');
pll_register_string('44east', 'Read More', '44east');
pll_register_string('44east', 'Learn More', '44east');
pll_register_string('44east', 'View More', '44east');
pll_register_string('44east', 'Other Services', '44east');

// Get acf repeater field from options page
$translationsField = get_field('translation_strings', 'option');

// Loop through repeater field
foreach ($translationsField as $translation) {
    // Register Polylang String
    pll_register_string('44east', $translation['string'], '44east');
}
