#!/bin/bash
# ==============================================
# 🚀 Script de réparation des permissions Bonresto

# ==============================================

# 📂 Chemin vers ton projet
PROJECT_PATH="C:\MAMP\htdocs\Bonresto"

echo "🔧 Réparation des permissions dans : $PROJECT_PATH"

# 1️⃣ Création des dossiers nécessaires
mkdir -p "$PROJECT_PATH/application/cache/temp"
mkdir -p "$PROJECT_PATH/application/logs"
mkdir -p "$PROJECT_PATH/assets/uploads"

# 2️⃣ Attribution des droits (lecture/écriture/exécution)
chmod -R 775 "$PROJECT_PATH/application/cache"
chmod -R 775 "$PROJECT_PATH/application/logs"
chmod -R 775 "$PROJECT_PATH/assets/uploads"

# 3️⃣ Détection automatique du système
if [[ "$OSTYPE" == "darwin"* ]]; then
  echo "🧩 Système détecté : macOS"
  OWNER="_www:_www"
  sudo chown -R $OWNER "$PROJECT_PATH/application/cache" 
"$PROJECT_PATH/application/logs" "$PROJECT_PATH/assets/uploads"
  echo "♻️ Redémarrage de XAMPP..."
  sudo /Applications/XAMPP/xamppfiles/xampp restart
else
  echo "🧩 Système détecté : Linux"
  OWNER="www-data:www-data"
  sudo chown -R $OWNER "$PROJECT_PATH/application/cache" 
"$PROJECT_PATH/application/logs" "$PROJECT_PATH/assets/uploads"
  echo "♻️ Redémarrage d’Apache..."
  sudo service apache2 restart


echo "✅ Permissions réparées avec succès !"
echo "📁 Vérifie que ton application fonctionne sur : 
http://localhost/Bonresto/"