#!/bin/bash

# Script to install DBeaver (Alternative to MySQL Workbench)
# DBeaver is free, cross-platform, and easier to install

echo "🔧 Installing DBeaver Community Edition..."
echo ""

# Detect OS
if [[ "$OSTYPE" == "linux-gnu"* ]]; then
    # Linux - Install via Snap (universal)
    echo "Installing DBeaver via Snap..."
    sudo snap install dbeaver-ce
    
    if [ $? -eq 0 ]; then
        echo ""
        echo "✅ DBeaver installed successfully!"
    else
        echo ""
        echo "❌ Failed to install via Snap"
        echo ""
        echo "Alternative installation methods:"
        echo "1. Download from: https://dbeaver.io/download/"
        echo "2. Install via package manager (if available)"
        exit 1
    fi
    
elif [[ "$OSTYPE" == "darwin"* ]]; then
    # macOS
    echo "Detected macOS system"
    if command -v brew &> /dev/null; then
        brew install --cask dbeaver-community
    else
        echo "❌ Homebrew not found"
        echo "Install Homebrew first: https://brew.sh/"
        echo "Or download DBeaver: https://dbeaver.io/download/"
        exit 1
    fi
else
    echo "❌ Unsupported operating system"
    echo "Please download DBeaver manually from: https://dbeaver.io/download/"
    exit 1
fi

echo ""
echo "📋 Connection Details for Aiven Database:"
echo "─────────────────────────────────────────────"
echo "Database Type: MySQL"
echo "Host: mysql-1536965f-st-f0b3.i.aivencloud.com"
echo "Port: 16208"
echo "Database: defaultdb"
echo "Username: avnadmin"
echo "Password: [Check .env file or ask team lead]"
echo ""
echo "SSL Settings:"
echo "  Use SSL: Yes"
echo "  SSL Mode: REQUIRED"
echo "  CA Certificate: $(pwd)/ca.pem"
echo ""
echo "🚀 Next Steps:"
echo "1. Launch DBeaver: 'dbeaver-ce' command or from app menu"
echo "2. Database → New Database Connection"
echo "3. Select MySQL and click Next"
echo "4. Fill in connection details above"
echo "5. Click 'Test Connection'"
echo "6. Go to 'Driver properties' or 'SSL' tab:"
echo "   - Enable 'Use SSL'"
echo "   - requireSSL = true"
echo "   - SSL CA: Browse to ca.pem"
echo "7. Click 'Finish'"
echo ""
echo "📖 Full guide: See AIVEN_DATABASE_SETUP.md"
echo ""
echo "💡 Tip: DBeaver supports many databases and has great features!"
