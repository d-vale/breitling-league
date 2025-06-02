<div id="top">

<!-- HEADER STYLE: CLASSIC -->
<div align="center">

# BREITLING LEAGUE

<em>Elevate Your Game, Engage with Every Challenge</em>

<!-- BADGES -->
<img src="https://img.shields.io/github/last-commit/d-vale/breitling-league?style=flat&logo=git&logoColor=white&color=0080ff" alt="last-commit">
<img src="https://img.shields.io/github/languages/top/d-vale/breitling-league?style=flat&color=0080ff" alt="repo-top-language">
<img src="https://img.shields.io/github/languages/count/d-vale/breitling-league?style=flat&color=0080ff" alt="repo-language-count">

<em>Built with the tools and technologies:</em>

<img src="https://img.shields.io/badge/Laravel-FF2D20.svg?style=flat&logo=Laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/React-61DAFB.svg?style=flat&logo=React&logoColor=black" alt="React">
<img src="https://img.shields.io/badge/TypeScript-3178C6.svg?style=flat&logo=TypeScript&logoColor=white" alt="TypeScript">
<img src="https://img.shields.io/badge/PHP-777BB4.svg?style=flat&logo=PHP&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/SQLite-003B57.svg?style=flat&logo=SQLite&logoColor=white" alt="SQLite">
<img src="https://img.shields.io/badge/TailwindCSS-06B6D4.svg?style=flat&logo=TailwindCSS&logoColor=white" alt="TailwindCSS">
<img src="https://img.shields.io/badge/Vite-646CFF.svg?style=flat&logo=Vite&logoColor=white" alt="Vite">

</div>
<br>

## Table of Contents

- [📖 Overview](#-overview)
- [🏆 Project Context](#-project-context)
- [✨ Key Features](#-key-features)
- [🎮 Game Modes](#-game-modes)
- [🚀 Getting Started](#-getting-started)
    - [Prerequisites](#prerequisites)
    - [Quick Installation](#quick-installation)
    - [Manual Installation](#manual-installation)
- [🌐 Application Access](#-application-access)
- [👥 Test Accounts](#-test-accounts)
- [🏗️ Technical Architecture](#️-technical-architecture)
- [📊 Database Structure](#-database-structure)
- [👨‍💻 Development](#-development)
- [🧪 Testing](#-testing)
- [📚 Documentation](#-documentation)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

## 📖 Overview

The **Breitling League** is a gamified training platform designed to revolutionize Breitling's educational system ahead of the annual Breitling Cup. This innovative application transforms traditional learning into an engaging, competitive experience that motivates sales associates worldwide to enhance their product knowledge and expertise.

## 🏆 Project Context

Developed as part of the **ProjArt course at HEIG-VD** for Breitling, the renowned Swiss luxury watchmaker. The project addresses Breitling's need to improve their training system and increase engagement among their global sales network through innovative gamification strategies.

### Why Breitling League?

- **Enhanced Engagement**: Transform boring training sessions into exciting competitions
- **Global Competition**: Connect sales associates worldwide through shared challenges
- **Knowledge Retention**: Gamified learning improves information retention by up to 75%
- **Performance Tracking**: Detailed analytics to monitor progress and identify top performers
- **Scalable Solution**: Designed to accommodate Breitling's global sales network

## ✨ Key Features

### 🎯 Core Gameplay

- **Dynamic Point System**: Earn points through various activities with different multipliers
- **Progressive Ranking**: 7-tier ranking system from Bronze to Timekeeper
- **Badge Collection**: Specialized badges for different areas of expertise
- **Real-time Leaderboards**: Global and regional performance tracking

### 🏅 Engagement Systems

- **Training Integration**: Seamlessly connect with existing Breitling education content
- **Social Competition**: Challenge colleagues and build team spirit
- **Achievement Tracking**: Comprehensive history of all activities and progress
- **Performance Analytics**: Detailed insights into learning patterns and strengths

### 🎨 User Experience

- **Modern Interface**: Clean, responsive design optimized for all devices
- **Intuitive Navigation**: Easy-to-use interface requiring minimal training
- **Accessibility**: WCAG compliant design ensuring inclusivity
- **Multi-language Support**: Ready for international deployment

## 🎮 Game Modes

### 🗺️ Main Quest

The core progression mode featuring:

- **Solo Training**: Individual skill development through structured courses
- **Novelty Focus**: Special 3-week windows for new product launches
- **Double Points**: Bonus scoring during novelty release periods
- **Badge Rewards**: Earn specialized badges for completing training modules

### ⚔️ Quiz Battles

Competitive peer-to-peer challenges:

- **Asynchronous Gameplay**: No need for real-time participation
- **Risk/Reward System**: Bet points on your performance
- **Rank-Based Matching**: Compete against players of similar skill level
- **72-Hour Time Limit**: Strategic timing adds excitement

### 🏟️ Novelties Arena

Intensive tournament mode:

- **High-Stakes Competition**: Premium rewards for top performers
- **Limited-Time Events**: 3-week tournaments per product launch
- **Expert-Level Content**: Challenging questions for product mastery
- **Podium Rewards**: Special recognition for top 3 finishers

## 🚀 Getting Started

### Prerequisites

Ensure you have the following installed on your system:

- **PHP 8.2+** with extensions: `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- **Composer** (latest version)
- **Node.js 18+** and **npm**
- **Git** for version control

### Quick Installation

1. **Clone and setup the project:**

    ```bash
    git clone https://github.com/d-vale/breitling-league.git
    cd breitling-league
    npm run setup
    ```

2. **Start the development server:**

    ```bash
    composer run dev
    ```

3. **Access the application:**
   Open your browser and navigate to `http://localhost:8000`

### Manual Installation

If you prefer to install manually or the automated script doesn't work:

<details>
<summary>Click to expand manual installation steps</summary>

1. **Clone the repository:**

    ```bash
    git clone https://github.com/d-vale/breitling-league.git
    cd breitling-league
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4. **Environment setup:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Database setup:**

    ```bash
    touch database/database.sqlite
    php artisan migrate:fresh --seed
    ```

6. **Build assets:**

    ```bash
    npm run build
    php artisan storage:link
    ```

7. **Start the server:**
    ```bash
    php artisan serve
    ```

</details>

## 🌐 Application Access

Once installed, access the application at:

- **Development URL**: `http://localhost:8000`
- **Production URL**: Configure in your deployment environment

## 👥 Test Accounts

The application comes pre-loaded with realistic test data representing different user levels:

### 🔑 Administrator Account

- **Email**: `admin@breitling.com`
- **Password**: `password`
- **Level**: Timekeeper (1,500,000 points)
- **Access**: Full administrative privileges

### 👤 Expert Users (Diamond Tier)

- **Sarah Johnson**: `sarah.johnson@breitling.com` - Aviation specialist (450,000 points)
- **Marcus Weber**: `marcus.weber@breitling.com` - Chronograph expert (380,000 points)

### 🥉 Professional Users (Platinum Tier)

- **Elena Rodriguez**: `elena.rodriguez@breitling.com` - Diving expert (220,000 points)
- **Thomas Chen**: `thomas.chen@breitling.com` - Technology specialist (180,000 points)

### 🥈 Experienced Users (Gold Tier)

- **Marie Dubois**: `marie.dubois@breitling.com` - Collector specialist (120,000 points)
- **David Thompson**: `david.thompson@breitling.com` - Sales expert (95,000 points)
- **Anna Kowalski**: `anna.kowalski@breitling.com` - Heritage specialist (88,000 points)

### 🥉 Intermediate Users (Silver Tier)

- **James Miller**: `james.miller@breitling.com` - Training participant (45,000 points)
- **Lisa Anderson**: `lisa.anderson@breitling.com` - Boutique specialist (52,000 points)
- **Roberto Silva**: `roberto.silva@breitling.com` - Regional representative (38,000 points)

### 🌱 New Users (Bronze Tier)

- **Sophie Martin**: `sophie.martin@breitling.com` - Recent trainee (15,000 points)
- **Yuki Tanaka**: `yuki.tanaka@breitling.com` - New team member (22,000 points)

**Default password for all accounts**: `password`

## 🏗️ Technical Architecture

### Backend (Laravel 12)

- **Framework**: Laravel 12 with modern PHP 8.2+ features
- **Database**: SQLite for development, MySQL/PostgreSQL ready for production
- **API**: RESTful API design with Inertia.js for seamless SPA experience
- **Authentication**: Laravel's built-in authentication with email verification
- **Queue System**: Database-driven queue for background processing

### Frontend (React 19)

- **Framework**: React 19 with TypeScript for type safety
- **Styling**: TailwindCSS 4.0 with custom design system
- **Components**: Radix UI primitives for accessibility
- **State Management**: React hooks and Inertia.js
- **Build Tool**: Vite for fast development and optimized builds

### Development Tools

- **Code Quality**: ESLint, Prettier, and TypeScript for consistency
- **Testing**: PHPUnit for backend, Jest for frontend
- **Version Control**: Git with conventional commits
- **CI/CD**: GitHub Actions ready configuration

## 📊 Database Structure

The application features a comprehensive database design:

### Core Entities

- **Users**: Complete user profiles with progress tracking
- **Ranks**: 7-tier progression system
- **Badges**: Specialized achievements and certifications
- **Quizzes**: Flexible quiz system with rich content
- **Questions & Choices**: Multiple choice questions with detailed feedback

### Game Mechanics

- **Quiz Battles**: Peer-to-peer competition system
- **Novelties Arena**: Tournament-style competitions
- **Responses**: Detailed answer tracking with timing
- **Historique**: Comprehensive activity logging

### Engagement Features

- **User Badges**: Achievement tracking
- **Novelties**: Product launch integration
- **Leaderboards**: Real-time ranking calculations

## 👨‍💻 Development

### Available Scripts

```bash
# Setup the project
npm run setup

# Development
composer run dev          # Start full development environment
php artisan serve         # Backend server only
npm run dev              # Frontend development server

# Building
npm run build            # Production build
npm run build:ssr        # Server-side rendering build

# Code Quality
npm run lint             # Run ESLint
npm run format           # Format code with Prettier
npm run types            # TypeScript type checking

# Testing
php artisan test         # Run PHP tests
npm run test            # Run JavaScript tests
```

### Development Guidelines

1. **Code Style**: Follow PSR-12 for PHP and Prettier config for TypeScript
2. **Git Workflow**: Use conventional commits and feature branches
3. **Testing**: Write tests for new features and maintain coverage
4. **Documentation**: Update README and inline documentation

## 🧪 Testing

The project includes comprehensive testing:

### Backend Testing (PHPUnit)

```bash
php artisan test                    # Run all tests
php artisan test --filter=Feature  # Feature tests only
php artisan test --filter=Unit     # Unit tests only
```

### Frontend Testing

```bash
npm run test           # Run JavaScript tests
npm run test:watch     # Watch mode for development
npm run test:coverage  # Generate coverage report
```

### Test Data

The application includes realistic test data:

- **15 specialized users** across all ranking tiers
- **15 comprehensive quizzes** covering all Breitling expertise areas
- **75+ quiz questions** with detailed explanations
- **Active competitions** and historical data

## 📚 Documentation

### Additional Resources

- **Business Requirements**: See `BreitlingLeague_BrochureExplicative.pdf` for detailed game rules
- **API Documentation**: Available at `/docs` when running in development mode
- **Database Schema**: Check `database/migrations/` for complete structure
- **Component Library**: Explore `resources/js/components/` for UI components

### Learning Path

1. **New Developers**: Start with Laravel and React documentation
2. **Feature Development**: Review existing quiz and battle implementations
3. **UI/UX**: Study the component library and design system
4. **Testing**: Follow existing test patterns in `tests/` directory

## 🤝 Contributing

We welcome contributions from the community! Please follow these guidelines:

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature/amazing-feature`
3. **Commit** your changes: `git commit -m 'Add amazing feature'`
4. **Push** to the branch: `git push origin feature/amazing-feature`
5. **Open** a Pull Request

### Contribution Guidelines

- Follow existing code style and conventions
- Add tests for new features
- Update documentation as needed
- Ensure all tests pass before submitting

## 📄 License

This project is developed for educational purposes as part of the ProjArt course at HEIG-VD.

**Team DJMK**: Daniel Vale, Jonathan Pinard, Joé Favre, Marc Bouriot, Kevin Dos Santos

---

<div align="center">

**Developed with ❤️ for Breitling**  
_Part of the ProjArt course at HEIG-VD_

<a href="#top">⬆ Return to Top</a>

</div>
