csonline
========

This is my registration system for my self-hosted MOOC Infrastructure.

1. See the file ```setup.sql``` for database setup instructions.

2. Copy ```config-dist``` to ```config.php``` and edit with the proper information.

3. See the ```patches``` folder to see if there are things that need patching like the 
tool.php code in the Moodle LTI provider - these patches actually are in the latest
Moodle LTI provider 

4. You will need to edit the text in various files like ```open.php``` and ```footer.php```.
I have genericized most strings where I can - but some large blobs od narrative
are just sitting in these files.

You also need to check this out as a top-level folder:

[git://gitorious.org/lightopenid/lightopenid.git](http://gitorious.org/lightopenid)

