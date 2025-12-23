pipeline {
    agent any

    environment {
        ENV = 'development'
        TARGET_DIR = '/var/amecweb/wwwroot/development/procurement'
    }

    tools {
        nodejs 'node'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scmGit(
                    branches: [[name: '*/main']],
                    userRemoteConfigs: [[
                        url: 'https://webhub.mitsubishielevatorasia.co.th/wsd/procurement.git',
                        credentialsId: 'gitlab-auth-id']
                    ]
                )
            }
        }

        stage('Install & Build on NAS') {
            steps {
                // ดึง Credentials มาใช้งานในรูปแบบตัวแปร GIT_USER และ GIT_PASS
                withCredentials([usernamePassword(credentialsId: 'gitlab-auth-id', passwordVariable: 'GIT_PASS', usernameVariable: 'GIT_USER')]) {
                    sh '''
                        echo "Current directory: $(pwd)"

                        # บอกให้ git แอบใส่ username:password เข้าไปใน URL ของ domain นี้โดยอัตโนมัติ
                        git config --global url."https://${GIT_USER}:${GIT_PASS}@webhub.mitsubishielevatorasia.co.th/".insteadOf "https://webhub.mitsubishielevatorasia.co.th/"

                        npm install
                        npm run build

                        # ลบการตั้งค่า url เพื่อความปลอดภัยหลังใช้งานเสร็จ
                        git config --global --unset url."https://${GIT_USER}:${GIT_PASS}@webhub.mitsubishielevatorasia.co.th/".insteadOf
                    '''
                }
            }
        }

        // stage('Deploy to NAS') {
        //     steps {
        //         sh '''
        //             mkdir -p ${TARGET_DIR}
        //             rsync -rlptvz --delete --no-perms --no-owner --no-group \
        //             dist/ ${TARGET_DIR}/
        //         '''
        //     }
        // }
    }
}