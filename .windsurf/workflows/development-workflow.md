---
description: Development workflow for the project
---

# Development Workflow

## Branch Structure
- **main**: Production branch - deployed via CI/CD pipeline
- **dev**: Development/testing branch - used for testing before production
- **feature/***: Feature branches - created from dev for individual features

## Daily Development Process

### 1. Start Working on New Feature
```bash
# Make sure you're on the latest dev branch
git checkout dev
git pull origin dev

# Create a new feature branch from dev
git checkout -b feature/your-feature-name
```

### 2. Development Work
- Work on your feature branch locally
- Commit your changes regularly
- Test your changes locally

### 3. Complete Feature
```bash
# Push your feature branch
git push origin feature/your-feature-name

# Create a Pull Request from feature branch to dev branch
# Go to GitHub and create PR: feature/your-feature-name -> dev
```

### 4. Testing Process
- PR will be reviewed and merged to dev branch
- Dev branch is used for testing
- After testing is complete, dev will be merged to main for production

### 5. Production Deployment
- Main branch is automatically deployed via CI/CD pipeline
- Never push directly to main branch

## Important Rules
- **NEVER** work directly on main branch
- **ALWAYS** create feature branches from dev branch
- **ALWAYS** create PRs from feature branches to dev branch (not main)
- Main branch is protected and only receives merges from dev after testing

## Commands Reference

### Clone Repository (New Setup)
```bash
git clone https://github.com/webzent-dev/institute-for-Livng-a-Longer-Life.git
cd institute-for-Livng-a-Longer-Life
git checkout dev
```

### Daily Workflow
```bash
# Start of day - get latest dev
git checkout dev
git pull origin dev

# Create feature branch
git checkout -b feature/new-feature

# Work and commit
git add .
git commit -m "Your commit message"

# Push feature branch
git push origin feature/new-feature
```

### After PR Merge to Dev
```bash
# Switch back to dev and get latest changes
git checkout dev
git pull origin dev

# Start next feature or end of day
```

## CI/CD Pipeline Setup

### GitHub Actions Configuration
The project includes GitHub Actions workflow that automatically deploys when code is pushed to `main` branch.

**Files created:**
- `.github/workflows/deploy.yml` - Main deployment pipeline (simplified - Node.js + FTP only)
- `.github/workflows/deploy-examples.yml` - Examples for different hosting providers

**Current Pipeline Steps:**
1. Checkout code
2. Setup Node.js
3. Install npm dependencies
4. Build assets (npm run build)
5. Deploy via FTP to server

### How CI/CD Connects to Your Workflow

1. **Development Process:**
   - Feature branches are created from `dev`
   - PRs merge feature branches into `dev` for testing
   - `dev` branch is used for testing and QA

2. **Production Deployment:**
   - After testing is complete, merge `dev` into `main`
   - GitHub Actions automatically triggers deployment in two ways:
     - When code is pushed to `main` branch
     - When PR from `dev` to `main` is merged
   - CI/CD only runs for merged PRs (not when PR is opened/closed without merge)

3. **Required GitHub Secrets:**
   Based on your hosting provider, add these secrets in GitHub repo settings:
   
   **For DigitalOcean:**
   - `DIGITALOCEAN_ACCESS_TOKEN`
   
   **For Vercel:**
   - `VERCEL_TOKEN`
   - `ORG_ID`
   - `PROJECT_ID`
   
   **For AWS EC2:**
   - `HOST`
   - `USERNAME`
   - `KEY`
   
   **For FTP:**
   - `FTP_SERVER` (your FTP server IP: 190.92.174.27)
   - `FTP_USERNAME` (your FTP username: living@bikewrapt.com)
   - `FTP_PASSWORD` (your FTP password: webzent@123)
   
   **FTP Setup Steps:**
   1. Go to GitHub repo settings
   2. Navigate to Secrets and variables > Actions
   3. Click "New repository secret"
   4. Add the three FTP secrets above:
      - FTP_SERVER = 190.92.174.27
      - FTP_USERNAME = living@bikewrapt.com
      - FTP_PASSWORD = webzent@123
   5. Server directory is already set to `/home/bike/public_html`

### Deployment Commands

**After testing complete, deploy to production:**
```bash
# Switch to main branch
git checkout main

# Merge dev into main
git merge dev

# Push to trigger CI/CD
git push origin main
```

**Alternative - Create PR from dev to main:**
```bash
# Create PR: dev -> main on GitHub
# After PR approval and merge, CI/CD automatically deploys
# This is the recommended approach for better code review
```
