pipeline {
    agent any

    environment {
        ENV = 'development'
        TARGET_DIR = '/var/amecweb/wwwroot/development/procurement'
        GIT_SSL_NO_VERIFY = 'true'
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

        stage('PHP Prep (Composer)') {
            steps {
                // ใช้คำสั่ง dir เพื่อ cd เข้าไปในโฟลเดอร์ application ก่อนรัน composer
                dir('application') {
                    sh 'composer install --no-dev --optimize-autoloader'
                }
                echo "PHP preparation with Composer done."
            }
        }

        stage('Deploy to NAS') {
            steps {
                sh '''
                    mkdir -p ${TARGET_DIR}

                    rsync -av --delete \
                        --exclude='node_modules' \
                        --exclude='.git' \
                        --exclude='.gitignore' \
                        ./ ${TARGET_DIR}/
                '''
            }
        }
    }
}