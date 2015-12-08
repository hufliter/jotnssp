user="jotunsho_user"
pass="xV8kA_~?OcA("
db=jotunsho_jotun
TABLES=$(mysql -u $user -p$pass --skip-column-names -B -D $db -e 'show tables')
for T in $TABLES
    do
        mysql -u $user -p$pass -D $db -e "ALTER TABLE \`$T\` ENGINE=InnoDB"
    done
