#!/bin/bash

echo "🚀 Setting up Laravel project after clone..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install

echo "📦 Installing NPM dependencies..."
npm install

# Copy environment file
echo "🔧 Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ .env file created"
else
    echo "ℹ️  .env file already exists"
fi

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Set permissions
echo "🔒 Setting up permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Run migrations (optional - uncomment if needed)
# echo "🗃️  Running database migrations..."
# php artisan migrate

echo ""
echo "🎉 Setup complete!"
echo ""
echo "Next steps:"
echo "1. Configure your .env file (database, app settings)"
echo "2. Run 'php artisan migrate' if you want to set up the database"
echo "3. Run 'php artisan serve' to start the development server"
echo ""