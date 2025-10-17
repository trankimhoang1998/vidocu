<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();

        if (empty($categories) || empty($users)) {
            $this->command->warn('Please run CategorySeeder and UserSeeder first.');
            return;
        }

        $posts = [
            [
                'title' => 'Getting Started with Laravel 11',
                'description' => 'A comprehensive guide to building modern web applications with Laravel 11.',
                'content' => 'Laravel 11 introduces exciting new features and improvements. In this article, we will explore the latest updates and how to leverage them in your projects. From enhanced performance to new Artisan commands, Laravel 11 makes development faster and more enjoyable.',
                'status' => 1,
            ],
            [
                'title' => 'Mastering Vue.js 3 Composition API',
                'description' => 'Learn how to build reactive and maintainable applications with Vue 3.',
                'content' => 'The Composition API in Vue 3 offers a more flexible way to organize and reuse logic in your components. This tutorial covers setup, reactive references, computed properties, and lifecycle hooks with practical examples.',
                'status' => 1,
            ],
            [
                'title' => 'Building RESTful APIs with Laravel',
                'description' => 'Best practices for designing and implementing RESTful APIs.',
                'content' => 'RESTful APIs are the backbone of modern web applications. Learn how to structure your routes, implement authentication, handle validation, and return consistent JSON responses. We\'ll also cover API versioning and rate limiting.',
                'status' => 1,
            ],
            [
                'title' => 'Advanced PHP 8.3 Features',
                'description' => 'Exploring the latest features in PHP 8.3 for better code quality.',
                'content' => 'PHP 8.3 brings numerous improvements including typed class constants, readonly amendments, and more. Discover how these features can help you write cleaner, more maintainable code with better type safety.',
                'status' => 0,
            ],
            [
                'title' => 'Docker for PHP Developers',
                'description' => 'Containerize your PHP applications with Docker.',
                'content' => 'Docker revolutionizes the way we deploy and run applications. This guide walks you through creating Dockerfiles, docker-compose configurations, and setting up development environments that mirror production.',
                'status' => 1,
            ],
            [
                'title' => 'Understanding Database Indexes',
                'description' => 'Optimize your database queries with proper indexing strategies.',
                'content' => 'Database indexes are crucial for application performance. Learn when to use single-column indexes, composite indexes, and full-text indexes. We\'ll also discuss index optimization and common pitfalls to avoid.',
                'status' => 1,
            ],
            [
                'title' => 'Tailwind CSS: A Utility-First Approach',
                'description' => 'Build beautiful interfaces faster with Tailwind CSS.',
                'content' => 'Tailwind CSS provides low-level utility classes that let you build completely custom designs. This article covers setup, responsive design, dark mode, and creating reusable components with Tailwind.',
                'status' => 1,
            ],
            [
                'title' => 'Testing Laravel Applications',
                'description' => 'Write comprehensive tests for your Laravel applications.',
                'content' => 'Testing is essential for building reliable applications. Learn how to write unit tests, feature tests, and browser tests using PHPUnit and Laravel Dusk. We\'ll cover mocking, database testing, and test-driven development.',
                'status' => 0,
            ],
            [
                'title' => 'JavaScript ES2024 New Features',
                'description' => 'Stay updated with the latest JavaScript language features.',
                'content' => 'ES2024 brings new array methods, improved error handling, and more. Discover how these features can simplify your code and improve readability. We\'ll provide practical examples for each new addition.',
                'status' => 1,
            ],
            [
                'title' => 'Secure Authentication in Laravel',
                'description' => 'Implement robust authentication and authorization systems.',
                'content' => 'Security is paramount in web applications. This guide covers Laravel Sanctum, Passport, session management, two-factor authentication, and best practices for protecting user data and preventing common vulnerabilities.',
                'status' => 1,
            ],
            [
                'title' => 'GraphQL vs REST: Making the Right Choice',
                'description' => 'Compare GraphQL and REST to choose the best API architecture.',
                'content' => 'Both GraphQL and REST have their strengths. This article analyzes performance, flexibility, complexity, and use cases to help you decide which approach suits your project requirements better.',
                'status' => 1,
            ],
            [
                'title' => 'Microservices Architecture with Laravel',
                'description' => 'Design and implement scalable microservices systems.',
                'content' => 'Microservices architecture enables better scalability and maintainability. Learn how to break monoliths into services, implement service communication, handle distributed transactions, and deploy microservices.',
                'status' => 0,
            ],
            [
                'title' => 'CSS Grid Layout Mastery',
                'description' => 'Create complex responsive layouts with CSS Grid.',
                'content' => 'CSS Grid is a powerful layout system. Master grid containers, grid items, alignment, auto-placement, and responsive design patterns. We\'ll build several real-world layouts from scratch.',
                'status' => 1,
            ],
            [
                'title' => 'Redis Caching Strategies',
                'description' => 'Improve application performance with Redis caching.',
                'content' => 'Redis is a high-performance key-value store perfect for caching. Learn caching strategies, cache invalidation, session storage, and implementing pub/sub patterns for real-time features.',
                'status' => 1,
            ],
            [
                'title' => 'Modern Git Workflows',
                'description' => 'Collaborate effectively with Git branching strategies.',
                'content' => 'Git is essential for version control. This article covers Git Flow, GitHub Flow, trunk-based development, and best practices for commits, pull requests, and code reviews.',
                'status' => 1,
            ],
            [
                'title' => 'Laravel Queue Management',
                'description' => 'Handle background jobs efficiently with Laravel queues.',
                'content' => 'Queues enable asynchronous processing. Learn to set up queue workers, handle job failures, implement job batching, and monitor queue performance for better application responsiveness.',
                'status' => 0,
            ],
            [
                'title' => 'Progressive Web Apps (PWA) Development',
                'description' => 'Build app-like experiences with Progressive Web Apps.',
                'content' => 'PWAs offer native app features in web applications. Discover service workers, offline functionality, push notifications, installation prompts, and performance optimization techniques.',
                'status' => 1,
            ],
            [
                'title' => 'SQL Query Optimization Techniques',
                'description' => 'Write efficient SQL queries for better database performance.',
                'content' => 'Query optimization is critical for scalability. Learn to analyze execution plans, optimize joins, use appropriate indexes, avoid N+1 queries, and implement query caching strategies.',
                'status' => 1,
            ],
            [
                'title' => 'Web Accessibility Best Practices',
                'description' => 'Make your websites accessible to everyone.',
                'content' => 'Accessibility ensures inclusivity. This guide covers ARIA attributes, semantic HTML, keyboard navigation, screen reader compatibility, color contrast, and testing tools for accessible web development.',
                'status' => 1,
            ],
            [
                'title' => 'Laravel Event Sourcing Patterns',
                'description' => 'Implement event-driven architecture in Laravel applications.',
                'content' => 'Event sourcing captures all changes as a sequence of events. Learn to implement event stores, projections, command handlers, and build audit trails for complex business logic.',
                'status' => 0,
            ],
            [
                'title' => 'TypeScript for JavaScript Developers',
                'description' => 'Add type safety to your JavaScript projects with TypeScript.',
                'content' => 'TypeScript enhances JavaScript with static typing. This tutorial covers types, interfaces, generics, decorators, and migrating existing JavaScript projects to TypeScript gradually.',
                'status' => 1,
            ],
        ];

        foreach ($posts as $index => $postData) {
            $slug = Str::slug($postData['title']);

            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            Post::create([
                'title' => $postData['title'],
                'slug' => $slug,
                'description' => $postData['description'],
                'content' => $postData['content'],
                'thumbnail' => null, // Will use default no-image.svg
                'category_id' => $categories[array_rand($categories)],
                'user_id' => $users[array_rand($users)],
                'status' => $postData['status'],
                'created_at' => now()->subDays(rand(0, 60)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('21 posts created successfully!');
    }
}
