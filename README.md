CBX Career Dev Toolkit

## Description

This plugin provides command line interface for creating dummy job and resume.

## Installation

1. Download the latest zip from [here](https://github.com/codeboxrcodehub/cbxcareertoolkit/releases)
2. WordPress has clear documentation about [how to install a plugin.](https://codex.wordpress.org/Managing_Plugins)
3. After install activate the plugin "CBX Career Dev Toolkit Library" through the 'Plugins' menu in WordPress
4. This plugin doesn't load any library by default, it doesn't create extra folder or menu.

# How to use:

## cbxjob

### All possible default params:

```
wp cbxjob-generate --total=100 --status=publish --is-remote=0 --is-featured=1 --is-filled=0 --user-id=1 --salary-unit=monthly --currency=USD
```

total = number of jobs to be created.

status options = [draft,pending,publish,unpublished,flag ]

is-remote = [0,1]

is-featured= [0,1]

is-filled= [0,1]

currency=[USD,BDT, etc]

salary-unit =[yearly,monthly,yearly,daily]

user-id = user ID

## cbxresume

### All possible default params:

```
wp cbxresume-generate --total=100 --user-id=1 --status=published --privacy=public --is-primary=1
```

total = number of resume to be created.

user-id= system user id

status options = [draft,pending,published,unpublished,flag ]

privacy= [public,private]

is-primary= [0,1]

## Licence

[MIT](https://github.com/codeboxrcodehub/cbxcareertoolkit/blob/master/LICENSE.txt)
