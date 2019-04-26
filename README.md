# twig-anysort-and-alphasort
Lightweight Twig filters to sort arrays and doctrine collections (objects): alphabetically, or by int, float, or DateTime.

Just copy this file in your project, or simply copy the relevant filters and imports.

Usage: for element in object.elements|anysort('key_name')

Default order is ASC.
For filtering in descending order, just add the Twig reverse filter.
e.g. for element in object.elements|anysort('key_name')|reverse  (or |reverse(true) to preserve the keys, if you really need that - replace every usort in the file by uasort)

alphasort filters only alphabetically (surprise), and is the primitive version of anysort. Delete if you don't need it.

Enjoy ;-)
