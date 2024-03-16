pipeline {
    agent any

    stages {
        stage("Test") {
            steps {
                echo 'testing the application...'
            }
        }

        stage('Run PHPUnit') {
            steps {
                sh 'chmod +x vendor/bin/phpunit'
                sh 'php vendor/bin/phpunit'
            }
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