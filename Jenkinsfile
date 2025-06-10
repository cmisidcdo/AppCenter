pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                sh 'composer install --no-interaction'
                sh 'php artisan optimize:clear' // Optionally clear cache
            }
        }
        stage('Test') {
            steps {
                sh 'vendor/bin/phpunit'
            }
        }
        stage('Deploy') {
            when {
                anyOf {
                    branch 'main'
                    branch 'develop'
                }
            }
            steps {
                sh 'echo "Deploying to production..."' // Replace with actual deployment steps
            }
        }
    }
}