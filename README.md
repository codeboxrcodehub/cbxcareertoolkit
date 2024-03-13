CBX Career Dev Toolkit

## Description
This plugin provides command line interface for creating dummy job and resume.

# How to use: 
## cbxjob
### All possible default params:

````
wp cbxjob-generate --total=100 --status=publish --is-remote=0 --is-featured=1 --is-filled=0 --user-id=1 --salary-unit=monthly --currency=USD
````


total = number of jobs to be created.

status options = [draft , pending , publish,unpublished,flag ]

is-remote = [0,1]

is-featured= [0,1]

is-filled= [0,1]

currency=[USD,BDT, etc]

salary-unit =[yearly,monthly,yearly,daily]

user-id = user ID


## cbxresume
### All possible default params:
````
wp cbxjresume-generate --total=100 --user-id=1 --status=1 --privacy=public --is-primary=1
````

total = number of resume to be created.

user-id= system user id

status = [0=draft, 1=publish, 2=unpublished, 3=pending, 4=flag]

privacy= [public,private]

is-primary= [0,1]

## Licence

[MIT](https://github.com/codeboxrcodehub/cbxcareertoolkit/blob/master/LICENSE.txt)
