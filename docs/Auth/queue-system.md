# Queue System Documentation

## Overview

Esar Cars uses Laravel Queue system to process time-consuming tasks asynchronously.

The main purpose of using queues is to improve API performance and avoid making users wait for slow operations such as sending emails.

Instead of sending emails during the request lifecycle, the system pushes tasks to a queue and processes them in the background.


---

# Why Use Queue?

Without Queue:

```
User Request

      |
      ↓

Create Account

      |
      ↓

Send Email

      |
      ↓

Wait Until Email Sent

      |
      ↓

Return Response
```


Problems:

- Slow response time
- User waits for email service
- External mail provider delays affect API
- Higher server load


---

With Queue:


```
User Request

      |
      ↓

Create Account

      |
      ↓

Dispatch Job

      |
      ↓

Return Response Immediately


Background Worker:

Job

 ↓

Send Email
```


Benefits:

- Faster API responses
- Better user experience
- Automatic retries
- Better scalability


---

# Queue Architecture


The project follows this flow:


```
Event

  |

  ↓

Listener

  |

  ↓

Job

  |

  ↓

Mail

  |

  ↓

User Email
```



Example:


```
User Registered

        |
        ↓

UserRegisteredEvent

        |
        ↓

SendVerificationEmailListener

        |
        ↓

SendVerificationEmailJob

        |
        ↓

VerifyEmailMail

        |
        ↓

User Inbox
```


---

# Queue Components


Laravel Queue system consists of:


## 1. Jobs Table


The `jobs` table stores pending background tasks.


Migration:


```bash
php artisan queue:table

php artisan migrate
```



Example record:


|Column|Description|
|-|-|
|id|Job identifier|
|queue|Queue name|
|payload|Serialized job data|
|attempts|Number of attempts|
|available_at|When job can run|
|created_at|Creation time|



Example:


```
id = 1

queue = default

attempts = 0
```



---

# 2. Failed Jobs Table


The `failed_jobs` table stores jobs that failed permanently.


Create table:


```bash
php artisan queue:failed-table

php artisan migrate
```



Contains:


|Column|Description|
|-|-|
|uuid|Unique job identifier|
|connection|Queue connection|
|queue|Queue name|
|payload|Job data|
|exception|Failure reason|



Used for:

- Debugging
- Retrying failed tasks
- Monitoring


---

# Queue Configuration


Configured in:


```
config/queue.php
```



Environment:


```
QUEUE_CONNECTION=database
```



This means:


```
Database Queue Driver

        |

        ↓

jobs table
```



---

# Jobs


Jobs represent tasks that should run in the background.


Example:


```
app/Jobs/SendVerificationEmailJob.php
```



Implementation:


```php
class SendVerificationEmailJob implements ShouldQueue
{
    use Queueable;


    public function handle()
    {
        // Send Email
    }
}
```



---

# ShouldQueue Interface


When a Job implements:


```php
ShouldQueue
```


Laravel does not execute it immediately.


Instead:


```
Dispatch Job

      |

      ↓

Store In jobs table

      |

      ↓

Worker Executes Later
```



---

# Job Retry System


Jobs support automatic retries.


Example:


```php
public int $tries = 3;
```



Meaning:


```
Attempt 1

   ↓ failed


Attempt 2

   ↓ failed


Attempt 3

   ↓ failed


Move To failed_jobs
```



---

# Backoff


Example:


```php
public int $backoff = 60;
```



Means:


After failure:


```
Wait 60 seconds

       |

       ↓

Retry Job
```



---

# Events


Events represent something that happened in the application.


Examples:


```
UserRegisteredEvent

VerificationEmailResentEvent

PasswordResetRequestedEvent
```



Events do not contain business logic.

Their responsibility:

- Carry data
- Notify listeners



Example:


```php
class UserRegisteredEvent
{
    public function __construct(
        public User $user,
        public EmailVerification $verification
    )
    {}
}
```



---

# ShouldHandleEventsAfterCommit


Events implement:


```php
ShouldHandleEventsAfterCommit
```



Purpose:


The event runs only after database transaction successfully commits.


Example:


```
Database Transaction

        |

        ↓

Create User

        |

        ↓

Create OTP

        |

        ↓

Commit Success

        |

        ↓

Dispatch Event

        |

        ↓

Send Email
```



Why?


To avoid sending emails for data that was rolled back.


---

# Listeners


Listeners react to events.


Example:


```
app/Listeners/SendVerificationEmailListener.php
```



Responsibility:


- Receive Event
- Dispatch Job


Example:


```php
public function handle(UserRegisteredEvent $event)
{

    SendVerificationEmailJob::dispatch(
        $event->user,
        $event->verification->otp
    );

}
```



---

# Implemented Events & Jobs


## Email Verification


Flow:


```
UserRegisteredEvent

        ↓

SendVerificationEmailListener

        ↓

SendVerificationEmailJob

        ↓

VerifyEmailMail
```



---

## Resend Verification Email


Flow:


```
VerificationEmailResentEvent

        ↓

SendVerificationEmailAfterResendListener

        ↓

SendVerificationEmailJob

        ↓

VerifyEmailMail
```



---

## Password Reset Email


Flow:


```
PasswordResetRequestedEvent

        ↓

SendPasswordResetEmailListener

        ↓

SendPasswordResetEmailJob

        ↓

PasswordResetMail
```



---

# Running Queue Worker


Start worker:


```bash
php artisan queue:work
```



Worker listens for new jobs:


```
jobs table

     |

     ↓

Execute Job

     |

     ↓

Remove Job
```



---

# Queue Commands


## Run Worker


```bash
php artisan queue:work
```


---

## See Failed Jobs


```bash
php artisan queue:failed
```


---

## Retry Failed Job


All failed jobs:


```bash
php artisan queue:retry all
```


Specific job:


```bash
php artisan queue:retry {id}
```


---

## Delete Failed Jobs


```bash
php artisan queue:flush
```


---

# Queue Restart


When code changes:


```bash
php artisan queue:restart
```


The worker will finish current jobs and restart.


---

# Production Recommendations


For production:


Use process manager:

Example:

```
Supervisor
```


Supervisor keeps queue worker alive:


```
Server Restart

      ↓

Supervisor

      ↓

Queue Worker Starts Automatically
```



---

# Monitoring


Recommended tools:


- Laravel Horizon
- Supervisor
- Server logs


Monitor:


- Failed jobs
- Processing time
- Retry count
- Queue size


---

# Security Considerations


Implemented:


✅ Sensitive data is not exposed in responses

✅ Failed jobs are logged

✅ Retry mechanism prevents permanent failures

✅ Database transactions protect data consistency

✅ Events execute after successful commit


---

# Summary


Queue system allows Esar Cars to:


- Send emails asynchronously
- Improve API performance
- Handle failures automatically
- Scale background tasks
- Keep application architecture clean
