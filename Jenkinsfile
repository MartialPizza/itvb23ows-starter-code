pipeline {
    agent any

    stages {
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