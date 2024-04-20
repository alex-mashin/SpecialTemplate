_SpecialTemplate_ is a _MediaWiki_ extension
intended to provide a way to create a wikilink to a wiki template
expanded with certain parameters,
without the need to create a wiki page transcluding that template.

Such a template behaves, effectively, as a new special page.

Examples:
 - suppose you have created _Template:Foo_ with
two parameters `{{{1}}}` and `{{{2}}}`.
Then to create a wikilink to this template with the parameters
`bar` and `baz`, add to any wikipage the code
`[[Special:Template/bar/baz]]`;
 - if you have _Template:Foo_ with a named parameter `{{{bar}}}`,
link to it like this: `[[Special:Template/Foo/bar=baz]]`;
 - to change the special page title,
add `_title`: `[[Special:Template/bar/baz/_title=BAR!]]`.

To install:
```bash
	cd extensions
	git clone https://github.com/alex-mashin/SpecialTemplate.git
```

For developers: this automates the recommended code checkers for PHP and JavaScript code in Wikimedia projects
(see https://www.mediawiki.org/wiki/Continuous_integration/Entry_points).
To take advantage of this automation.

1. install nodejs, npm, and PHP composer
2. change to the extension's directory
3. `npm install`
4. `composer install`

Once set up, running `npm test` and `composer test` will run automated code checks.
