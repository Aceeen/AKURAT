#!/bin/bash
# Merakit container
docker-compose up -d --build

# Tunggu database siap
echo "Menunggu database siap..."
sleep 10

# Migrasi dan Seeding data awal
docker exec akurat_app php artisan migrate:fresh --seed --force
docker exec akurat_app php artisan storage:link
docker exec akurat_app php artisan config:cache

echo "🚀 AKURAT BERHASIL DEPLOY KE INTERNET!"