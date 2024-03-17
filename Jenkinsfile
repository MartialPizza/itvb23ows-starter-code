pipeline {
    agent {
        label 'docker'
    }

    stages {

        stage('Run PHPUnit') {
            agent {
                docker {
                    label 'docker'
                    image 'composer:lts'
                }
            }
            steps {
                sh 'composer install'
                sh 'vendor/bin/phpunit ./'
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