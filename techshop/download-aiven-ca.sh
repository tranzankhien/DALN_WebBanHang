#!/bin/bash

# Script to download Aiven CA certificate

echo "📥 Downloading Aiven CA certificate..."

# Download the CA certificate from Aiven
curl -o ca.pem https://mysql-1536965f-st-f0b3.i.aivencloud.com:16208/ssl-ca

# If the above doesn't work, try this alternative method
if [ ! -f ca.pem ] || [ ! -s ca.pem ]; then
    echo "Trying alternative download method..."
    # Download from Aiven's documentation page
    curl -o ca.pem https://api.aiven.io/v1/project/default/service/default/ca
fi

# Check if file was downloaded successfully
if [ -f ca.pem ] && [ -s ca.pem ]; then
    echo "✅ CA certificate downloaded successfully!"
    echo "File location: $(pwd)/ca.pem"
    ls -lh ca.pem
else
    echo "❌ Failed to download CA certificate automatically."
    echo ""
    echo "Please download manually from Aiven console:"
    echo "1. Go to your Aiven service page"
    echo "2. Click on 'CA certificate' Show/Download button"
    echo "3. Save the file as 'ca.pem' in this directory: $(pwd)"
fi
