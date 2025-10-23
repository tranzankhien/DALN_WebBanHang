#!/bin/bash

# Script to install and setup MySQL Workbench for Aiven database visualization

echo "🔧 Installing MySQL Workbench..."
echo ""

# Detect OS
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    # Linux
    if command -v apt &> /dev/null; then
        # Debian/Ubuntu
        echo "Detected Debian/Ubuntu system"
        sudo apt update
        sudo apt install -y mysql-workbench
    elif command -v dnf &> /dev/null; then
        # Fedora
        echo "Detected Fedora system"
        sudo dnf install -y mysql-workbench
    elif command -v yum &> /dev/null; then
        # CentOS/RHEL
        echo "Detected CentOS/RHEL system"
        sudo yum install -y mysql-workbench
    else
        echo "❌ Unsupported Linux distribution"
        echo "Please install MySQL Workbench manually from: https://dev.mysql.com/downloads/workbench/"
        exit 1
    fi
elif [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    echo "Detected macOS system"
    if command -v brew &> /dev/null; then
        brew install --cask mysqlworkbench
    else
        echo "❌ Homebrew not found"
        echo "Install Homebrew first: https://brew.sh/"
        echo "Or download MySQL Workbench: https://dev.mysql.com/downloads/workbench/"
        exit 1
    fi
else
    echo "❌ Unsupported operating system"
    echo "Please install MySQL Workbench manually from: https://dev.mysql.com/downloads/workbench/"
    exit 1
fi

echo ""
echo "✅ MySQL Workbench installed successfully!"
echo ""
echo "📋 Connection Details for Aiven Database:"
echo "─────────────────────────────────────────"
echo "Connection Name: TechShop Aiven"
echo "Hostname: mysql-1536965f-st-f0b3.i.aivencloud.com"
echo "Port: 16208"
echo "Username: avnadmin"
echo "Password: [Check .env file or ask team lead]"
echo "Default Schema: defaultdb"
echo ""
echo "SSL Settings:"
echo "  SSL Mode: Require"
echo "  SSL CA File: $(pwd)/ca.pem"
echo ""
echo "🚀 Next Steps:"
echo "1. Open MySQL Workbench"
echo "2. Click '+' to create new connection"
echo "3. Fill in the connection details above"
echo "4. Go to SSL tab and set:"
echo "   - Use SSL: Yes"
echo "   - SSL Mode: Require"
echo "   - SSL CA File: Browse to ca.pem file"
echo "5. Test Connection"
echo "6. Click OK to save"
echo ""
echo "📖 Full guide: See AIVEN_DATABASE_SETUP.md"
