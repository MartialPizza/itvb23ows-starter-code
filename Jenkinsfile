pipeline {
    agent any

    stages {
        stage("build") {
            steps {
                echo 'building the application...'
            }
        }

        stage("test") {
            steps {
                echo 'testing the application...'
            }
        }

        stage("deploy") {
            steps {
                echo 'deploying the application...'
            }
        }

        stage("Scan") {
            steps {
                script {
                    scannerHome = tool 'SonarQube Scanner 5.0.1.3006'
                }
                withSonarQubeEnv('SonarQubePipeline') {
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }
    }
}