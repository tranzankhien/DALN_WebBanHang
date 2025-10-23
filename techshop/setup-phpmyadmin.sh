#!/bin/bash

# Script to configure phpMyAdmin for root access without password

echo "🔧 Configuring phpMyAdmin for root access..."

# Backup original config
sudo cp /etc/phpmyadmin/config.inc.php /etc/phpmyadmin/config.inc.php.backup

# Create custom config for root access
sudo bash -c 'cat >> /etc/phpmyadmin/config.inc.php <<EOF

/* Custom configuration for root access without password */
\$cfg["Servers"][\$i]["auth_type"] = "config";
\$cfg["Servers"][\$i]["user"] = "root";
\$cfg["Servers"][\$i]["password"] = "";
\$cfg["Servers"][\$i]["AllowNoPassword"] = true;
EOF'

echo "✅ phpMyAdmin configured!"
echo ""
echo "You can now access phpMyAdmin at: http://localhost/phpmyadmin"
echo "It will automatically log in as root without asking for password"
