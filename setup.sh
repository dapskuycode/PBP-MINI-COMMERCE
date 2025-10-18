#!/bin/bash

echo "🚀 Setting up PBP Mini Commerce..."

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📦 Installing NPM dependencies..."
npm install

# Setup storage symlink
echo "🔗 Creating storage symlink..."
if [ -L public/storage ]; then
    echo "   Removing existing symlink..."
    rm public/storage
fi
php artisan storage:link

# Setup database
echo "🗄️ Setting up database..."
php artisan migrate --force

# Optional: Seed database
read -p "🌱 Do you want to seed the database with sample data? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed
fi

echo "✅ Setup complete!"
echo ""
echo "🎉 You can now run: php artisan serve"
echo "📸 Images will be available at: http://localhost:8000/storage/photos/"