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
                    scannerHome = tool 'SonarQube Scanner 2.16.1'
                }
                withSonarQubeEnv('SonarQubePipeline') {
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }
    }
}