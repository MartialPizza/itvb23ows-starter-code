pipeline {
    agent any

    stages {

        stage("Composer install") {
            sh 'composer update'
        }

        stage("Run PHPUnit") {
            sh 'vendor/bin/phpunit'
        }

        stage("Scan") {
            steps {
                script {
                    scannerHome = tool 'SonarQube Scanner 2.8'
                }
                withSonarQubeEnv('SonarQube') {
                    sh "${scannerHome}/bin/sonar-scanner \
                    -Dsonar.projectKey=OWS \
                    -Dsonar.sources=. "
                }
            }
        }
    }
}