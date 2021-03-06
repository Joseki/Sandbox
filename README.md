Sandbox
=======

Application skeleton for Nette Framework applications with many additional features:

- LeanMapper ORM included
  - Query objects
  - auto service registration based on simple Entity-table mapping in neon config
  - closure tables
- Phinx database migration including initial script
- Package based directory structure 
- separated neon config files for each extension (to clarify these config files)
- less -> css templates written in attribute-selector way in resources/design/
- example for simple testing mechanism using Nette/Tester in tests/


Install
======================
using Composer (note that webroot is just a name of a directory where your project will be created. Feel free to change webroot to whatever you like)
```
composer create-project joseki/sandbox webroot
```

move to webroot directory
```
cd webroot
```

create config.local.neon and add valid credentials to a database layer
```
cp app/config/template/config.local.neon app/config/config.local.neon
vim app/config/config.local.neon
```

create SQL tables using Phinx migration tool
```
libs/composer/bin/phinx migrate
```

Packages name
=============
In your IDE (PhpStorm, NetBeans or whatever you use), replace all occurencies of MyApplication with whatever is your project name namespace (e.g. Joseki). Also rename app/MyApplication as well (in my case to Joseki).

In this skeleton, I use composer to autoload my application scripts in app/ directory the same way as I do with dependecies stored in libs/ (vendor) directory so you need to call:

```
composer update
```

That's all folks!
