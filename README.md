# Shady

A shady Slim-Framework extend that solves some annoying 'features'...

## What does it do?

Fixes some Slim-'features':
- Slim routing disallows using other solutions than the standard Apache Rewrite rules. The Slim Framework can't be used if you're using Virtual-hosts module with dynamic domains
- Slim disallows the use of non-anonymous functions for routing. This makes reusing your code impossible

## How to install?

Use Composer to install Shady and it's dependencies (Slim + PHP)
