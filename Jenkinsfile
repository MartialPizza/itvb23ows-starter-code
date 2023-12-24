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
                def scannerHome = tool name: 'sonar_scanner', type: 'hudson.plugins.sonar.SonarRunnerInstallation';
                withSonarQubeEnv('SonarQubePipeline') {
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }
    }
}