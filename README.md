domain-wpcli
============

Switch domains for a WordPress single site or network from the command line with WP CLI

##usage

Its's easy update the database with the new domain by using the following command. It uses 2 parameters <old> and <new>. http or https doesn't have to be added. The command is protocol independent. 

    wp domain move <old> <new>

    wp domain move dev.domain.com test.domain.com
    
  
Remember to update vhost configuration and hosts files if necessary.
