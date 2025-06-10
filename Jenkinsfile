pipeline {
    agent any
    environment {
        APP_ENV = 'production'
        COMPOSER_ALLOW_SUPERUSER = 1
        NODE_VERSION = '18.x'  // Change Node version as needed
    }
    stages {
        // Stage 1: Checkout source code
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        
        // Stage 2: Install system dependencies
        stage('Setup Environment') {
            steps {
                script {
                    // Install PHP dependencies (example for Ubuntu)
                    sh 'sudo apt-get update && sudo apt-get install -y php-cli php-mbstring php-xml php-mysql php-curl zip unzip'
                    
                    // Install Node.js
                    sh "curl -sL https://deb.nodesource.com/setup_${NODE_VERSION} | sudo -E bash -"
                    sh 'sudo apt-get install -y nodejs'
                    
                    // Install Composer
                    sh 'curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer'
                }
            }
        }
        
        // Stage 3: Install PHP dependencies
        stage('Composer Install') {
            steps {
                sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }
        
        // Stage 4: Install JavaScript dependencies
        stage('NPM Install') {
            steps {
                sh 'npm ci --no-progress'
            }
        }
        
        // Stage 5: Environment setup
        stage('Environment Setup') {
            steps {
                // Copy example env file (create if not exists)
                sh 'cp -n .env.example .env || true'
                
                // Generate app key
                sh 'php artisan key:generate'
                
                // Set secure environment variables (configure in Jenkins)
                withCredentials([
                    string(credentialsId: 'DB_PASSWORD', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'APP_KEY', variable: 'APP_KEY')
                ]) {
                    sh "sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASSWORD}/' .env"
                    sh "sed -i 's/APP_KEY=.*/APP_KEY=${APP_KEY}/' .env"
                }
            }
        }
        
        // Stage 6: Run database migrations
        stage('Database Migration') {
            steps {
                sh 'php artisan migrate --force'
            }
        }
        
        // Stage 7: Run tests
        stage('Run Tests') {
            steps {
                sh 'php artisan test --stop-on-failure'
            }
        }
        
        // Stage 8: Build assets
        stage('Build Assets') {
            steps {
                sh 'npm run production'
            }
        }
        
        // Stage 9: Deploy to server (example using SSH)
        stage('Deploy') {
            when {
                branch 'main'  // Only deploy from main branch
            }
            steps {
                sshagent(['deploy-ssh-key']) {
                    sh """
                    rsync -avz --delete \
                        --exclude='.env' \
                        --exclude='.git' \
                        --exclude='node_modules' \
                        . ${DEPLOY_USER}@${DEPLOY_HOST}:${DEPLOY_PATH}
                    """
                }
                // Run deployment commands remotely
                sh "ssh ${DEPLOY_USER}@${DEPLOY_HOST} 'cd ${DEPLOY_PATH} && php artisan optimize:clear && php artisan optimize'"
            }
        }
    }
    
    post {
        always {
            // Clean workspace after build
            cleanWs()
        }
        success {
            // Send success notifications
            slackSend(color: 'good', message: "Laravel Pipeline SUCCESSFUL: ${env.JOB_NAME} #${env.BUILD_NUMBER}")
        }
        failure {
            // Send failure notifications
            slackSend(color: 'danger', message: "Laravel Pipeline FAILED: ${env.JOB_NAME} #${env.BUILD_NUMBER}")
        }
    }
}