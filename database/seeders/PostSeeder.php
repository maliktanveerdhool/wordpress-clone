<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $designer = User::query()->where('email', 'priya@example.com')->firstOrFail();

        $categories = Category::pluck('id', 'slug');
        $tags = Tag::pluck('id', 'slug');

        $posts = [
            [
                'title' => 'The quiet craft of building a personal website',
                'slug' => 'quiet-craft-personal-website',
                'category' => 'design',
                'author' => $designer,
                'tags' => ['craft', 'slow-web', 'writing'],
                'excerpt' => 'A personal site is not a product. It is a room you keep arranging until it feels like yours.',
                'views' => 1284,
                'featured' => true,
                'days' => 2,
                'body' => <<<'MD'
                There is a particular kind of pleasure in opening a blank file and typing a heading that no one asked for. No brief, no stakeholder, no conversion target. Just a page, a font you like, and the slow work of deciding what belongs on it.

                Personal websites used to be the default. You had one because making one was the point. Then the platforms arrived and promised that you could have a presence without the trouble of building one — and for a while that seemed like a fair trade.

                It was not, quite.

                ## A site is a place, not a profile

                A profile is a shape the platform already decided on. You fill in the fields: name, headline, a link, a photo cropped to a circle. A website is the opposite. You choose the rooms, the doors, the light.

                That freedom is uncomfortable at first. When nothing is prescribed, every decision is yours, and every decision can be wrong. But the discomfort is the useful part. It forces you to ask what you actually want to say.

                > The best personal sites feel less like portfolios and more like apartments you have been invited into.

                ## Start smaller than you think

                The most common failure mode is scope. A blog, a projects page, a reading list, a newsletter, a shop, a wiki — all sketched before a single sentence is published.

                Instead, start with one page that answers one question:

                - Who are you, in two sentences?
                - What are you working on right now?
                - Where can someone reach you?

                That is a complete website. Everything else is an addition you earn the right to make by using the thing you already have.

                ## The parts that age well

                After a decade of watching personal sites come and go, a few choices keep proving themselves:

                1. **Plain text.** Write in Markdown. Keep the source readable ten years from now.
                2. **Your own domain.** The only part of your identity a platform cannot take back.
                3. **Few dependencies.** Every script you add is a future afternoon of maintenance.
                4. **A real date.** Undated writing ages strangely. Dates are honest.

                None of this is exciting. That is the point. A personal site is infrastructure for thinking in public, and infrastructure should be boring enough to forget about.

                ## Finish something small

                The site you publish this weekend will be better than the perfect one you are still planning. It will also teach you things the plan never could: which page you keep opening, which sentence you keep editing, which part of yourself you actually wanted to show.

                Start with a heading no one asked for. See where it goes.
                MD,
            ],
            [
                'title' => 'Why Laravel still feels like cheating (in a good way)',
                'slug' => 'laravel-feels-like-cheating',
                'category' => 'technology',
                'author' => $admin,
                'tags' => ['laravel', 'php', 'tools'],
                'excerpt' => 'Every framework promises to remove boilerplate. Laravel removes the excuses instead.',
                'views' => 962,
                'days' => 5,
                'body' => <<<'MD'
                The first time you build something real in Laravel, there is a moment where you suspect you have skipped a step. Authentication, validation, queues, mail, migrations, pagination — the tedious parts of an application arrive already solved, with sensible defaults and documentation that assumes you are busy.

                It feels like cheating because most of us learned to equate effort with quality. But the effort was never the point.

                ## Convention as a kindness

                Laravel is opinionated in a way that is easy to mistake for magic. A model named `Post` looks for a table named `posts`. A controller method returns a view with a matching name. Routes, policies, factories and tests all line up without a configuration file explaining the arrangement.

                The benefit is not typing speed. It is that a new developer can open the project and guess where things live.

                ```php
                Route::get('/posts/{post}', [PostController::class, 'show'])
                    ->name('posts.show');
                ```

                That route does what it says. The model binding, the 404, the named URL — all handled. Nothing hidden that you would not eventually write yourself.

                ## The ecosystem is the real feature

                First-party packages cover the awkward middle of web development: queues with Horizon, billing with Cashier, real-time with Reverb, local mail with Herd. They share conventions, so learning one teaches you something about the others.

                This is rare. Most ecosystems give you a framework and a directory of third-party packages with competing philosophies. Laravel gives you a house style.

                ## Where it can go wrong

                The same generosity that makes Laravel pleasant can make it heavy. Not every project needs eleven service providers. A quick internal tool does not require an event-driven architecture, and a marketing page does not need a queue worker.

                The framework will happily let you build more than you need. Restraint is still your job.

                > Use the framework for the boring parts. Spend your imagination on the part only you can build.

                ## A fair summary

                Laravel feels like cheating because it respects your time. It assumes you would rather ship the feature than wire the plumbing, and it is not embarrassed about that.

                After a few years, the novelty fades and what remains is quieter: a codebase that a colleague can read, a deploy that does not surprise you, and an afternoon that ends with something working. That is not cheating. That is craft.
                MD,
            ],
            [
                'title' => 'A field guide to typography on the web',
                'slug' => 'field-guide-web-typography',
                'category' => 'design',
                'author' => $designer,
                'tags' => ['typography', 'craft', 'design'],
                'excerpt' => 'Most typography advice is about taste. This is about the handful of decisions that actually change how a page reads.',
                'views' => 812,
                'days' => 9,
                'body' => <<<'MD'
                You do not need a hundred fonts. You need two, chosen deliberately, and the patience to set them well.

                Typography on the web is mostly a negotiation between the text and the screen. The screen is impatient; the text wants to be read slowly. Good typography is the set of decisions that let both get what they want.

                ## Start with the body

                Choose the body face first. Everything else is a supporting actor. Look for:

                - A generous x-height, so lowercase letters stay legible at 16–18px
                - Open counters in letters like *a*, *e* and *g*
                - A real italic and a real bold, not a synthesised one
                - Enough weights to build hierarchy without changing family

                A single well-made family, used with discipline, will outperform three fashionable ones used carelessly.

                ## Measure, then size

                Line length matters more than font size. A comfortable measure is somewhere between 60 and 75 characters. On a wide screen that means constraining the text column rather than shrinking the type.

                ```css
                .prose {
                    max-width: 68ch;
                    font-size: 1.0625rem;
                    line-height: 1.75;
                }
                ```

                Line height should loosen as the measure widens. A narrow sidebar can take 1.4; a long article wants 1.7 or more.

                ## Hierarchy without noise

                Most pages do not need more than four levels of text: heading, subheading, body, caption. If you find yourself reaching for a fifth size, the structure is probably unclear.

                > If everything is emphasised, nothing is.

                Use space before you use weight. A heading with 2rem of air above it reads as a heading even at the same size as the body.

                ## The details worth sweating

                - **Hanging punctuation** in pull quotes
                - **Optical alignment** of large headings
                - **Tabular numbers** in tables, proportional numbers in prose
                - **Real dashes** — em for interruption, en for ranges
                - **A deliberate link style** that survives being read aloud

                These are small things. They are also the difference between a page that feels designed and a page that feels assembled.

                ## Read it out loud

                The final test is not visual. Read the page in your head at speaking pace. Where you stumble, the typography is asking too much of you. Fix that line, that paragraph, that gap — and read it again.
                MD,
            ],
            [
                'title' => 'The case for working in public',
                'slug' => 'case-for-working-in-public',
                'category' => 'culture',
                'author' => $admin,
                'tags' => ['writing', 'productivity', 'remote-work'],
                'excerpt' => 'Sharing unfinished work is uncomfortable, which is precisely why it makes the work better.',
                'views' => 640,
                'days' => 14,
                'body' => <<<'MD'
                For years I kept a folder called `drafts` and almost never opened it. Ideas went in, polished nothing came out. The folder was a place to be safe, and safety was the problem.

                Working in public is the opposite of that folder. It is the decision to let a thing be seen before it is finished.

                ## What it actually means

                Working in public does not require an audience. It requires a small, honest habit: publishing the note, showing the sketch, writing the changelog entry that admits what is still broken.

                It can be as small as a weekly sentence. The size is not the point; the exposure is.

                ## Why it works

                Three things happen when you know someone might read the work:

                1. **You finish the thought.** Half-ideas survive in private. In public they need a verb and a subject.
                2. **You get corrected early.** The expensive mistakes are the ones discovered after three weeks of silence.
                3. **You build a record.** Not a highlight reel — a trail of how the thinking actually went.

                That third one compounds. Six months of small notes becomes a body of work you can point at, reuse, and learn from.

                > Privacy is for the messy middle. Public is for the part that has stopped changing.

                ## The fear is accurate

                Let us not pretend otherwise. Someone will find the mistake. Someone will disagree, sometimes unkindly. The first few times, it stings.

                What helps is lowering the stakes deliberately:

                - Publish in a place with a small audience
                - Write about what you are learning, not what you have mastered
                - Keep a private space for the truly rough material
                - Reply to disagreement with curiosity, not defence

                The goal is not fearlessness. It is a tolerance for being seen mid-sentence.

                ## A practical start

                Pick one thing you did this week that surprised you. Write four paragraphs: what you expected, what happened, why, and what you will do next. Do not edit it more than twice.

                Post it somewhere small. Then go make tea.

                That is the whole practice. Everything else is scale.
                MD,
            ],
            [
                'title' => 'Slow travel, fast trains: two weeks through Japan',
                'slug' => 'slow-travel-fast-trains-japan',
                'category' => 'travel',
                'author' => $designer,
                'tags' => ['travel', 'slow-web', 'craft'],
                'excerpt' => 'The trains are punctual. The country rewards anyone willing to be late on purpose.',
                'views' => 1580,
                'days' => 21,
                'body' => <<<'MD'
                The first thing you notice is the quiet. Not silence exactly — the carriage hums, announcements chime politely — but a kind of agreed calm. Fourteen days of it changed how I walk through cities.

                We had planned three cities in two weeks. It was, in retrospect, a beginner's plan.

                ## Tokyo, in the early morning

                Arriving at 6am means you see the city before it puts on its face. Delivery bikes, shutters going up, a man hosing down the pavement outside a kissaten. We sat in a tiny café and drank coffee that tasted like it had been considered.

                The guidebooks tell you to see the crossings and the towers. The better advice is to pick one neighbourhood and walk it until you are bored. Boredom is where the interesting details live.

                ## Kanazawa, where the pace drops

                The shinkansen gets you there in a couple of hours, but the town itself refuses to hurry. We spent a morning in the Kenroku-en garden watching gardeners work with tools that looked older than the trees.

                - The gardens are raked daily
                - The gold leaf shops open late
                - Nobody seems to be in a rush to sell you anything

                > Travel at the speed of the place, not the speed of your itinerary.

                ## The trains as a design lesson

                A Japanese train timetable is a piece of interface design. Signs tell you where to stand. The platform marks tell you which carriage. The carriage tells you where to put your bag.

                Nobody has to explain it. The system anticipates the question and answers it before you ask. It is the same principle as a good form: reduce the moment of uncertainty.

                ## What I brought home

                Not souvenirs, mostly habits:

                1. Leave earlier than necessary.
                2. Sit down for lunch, properly, without a screen.
                3. Notice the maintenance — the swept path, the trimmed hedge, the replaced tile.
                4. Say thank you out loud, even when the transaction is over.

                Two weeks is not enough to understand a country. It is enough to interrupt your own defaults. That, it turns out, is what the ticket is for.
                MD,
            ],
            [
                'title' => 'Tailwind CSS after two years: what stuck',
                'slug' => 'tailwind-after-two-years',
                'category' => 'technology',
                'author' => $admin,
                'tags' => ['tailwind', 'javascript', 'tools'],
                'excerpt' => 'A utility-first stylesheet is a tool, not a philosophy. Here is what earned its place in the toolbox.',
                'views' => 733,
                'days' => 27,
                'body' => <<<'MD'
                I resisted Tailwind for a year. The markup looked noisy, the class lists looked unmaintainable, and I had a perfectly good set of hand-written CSS files, thank you very much.

                Then I shipped a redesign in a weekend and stopped arguing.

                ## What actually changed

                The honest answer is not "utility classes are beautiful". It is that the feedback loop got shorter. I stopped inventing names for things, stopped hunting for where a rule lived, and stopped leaving dead CSS behind.

                ```html
                <button class="rounded-full bg-ink px-5 py-2.5 text-sm font-medium text-white transition hover:bg-stone-800">
                    Publish
                </button>
                ```

                Everything the button needs is on the button. When the button is deleted, so is its styling.

                ## The parts that aged well

                - **Design tokens.** Colours and spacing come from a single theme, so a palette change is a small change.
                - **Component extraction.** Repeated patterns become Blade, React or Vue components, not CSS classes.
                - **Responsive variants.** `md:` prefixes read naturally once you are used to them.
                - **Zero runtime.** It is a build step, not a library shipped to the browser.

                ## The parts that need discipline

                Utility classes make it easy to be inconsistent. Two developers can build the same card with three different paddings and never notice.

                The fix is not to abandon the approach. It is to name your decisions:

                1. Keep a small set of components for repeated UI.
                2. Put brand values in the theme, not in arbitrary brackets.
                3. Review markup in pull requests the way you review logic.
                4. Delete variants you are not using.

                > A design system is not a stylesheet. It is an agreement about what things should look like.

                ## Would I choose it again?

                Yes — for product UI, marketing pages and the kind of application where the design changes weekly. Probably not for a long-form editorial site where the prose styles deserve their own careful CSS.

                That distinction matters. Tailwind is very good at layout and state. Long-form reading still benefits from a hand-tuned stylesheet with real typographic decisions.

                The tool did not replace taste. It just got out of the way of applying it.
                MD,
            ],
            [
                'title' => 'How to read more without trying harder',
                'slug' => 'how-to-read-more',
                'category' => 'culture',
                'author' => $designer,
                'tags' => ['productivity', 'writing'],
                'excerpt' => 'Reading goals fail for the same reason gym memberships do. Lower the activation energy instead.',
                'views' => 421,
                'days' => 35,
                'body' => <<<'MD'
                Every January I set a reading goal. Every March I forget it existed. The books pile up in a way that feels like ambition and functions as guilt.

                The year it finally worked, I did not try harder. I removed friction.

                ## Make the next page easy

                A book you have to find is a book you will not read. So:

                - Keep one book on the sofa, open, face down
                - Keep one in your bag, always
                - Keep the phone in another room during the ten minutes before sleep

                None of these are discipline. They are logistics.

                ## Let books be abandoned

                The single biggest change was permission to stop. A book you are not enjoying is not a moral obligation. Give it fifty pages. If it has not earned the next fifty, put it down without ceremony.

                This sounds obvious and is strangely hard. But the alternative is a reading list that becomes a graveyard.

                > Reading more is mostly reading the thing in front of you.

                ## Mix the modes

                Not everything needs to be a book. Essays, long articles, documentation, poetry — all of it counts. The goal is a habit of attention, not a number on a spreadsheet.

                I keep three stacks:

                1. **Morning:** something difficult, ten pages
                2. **Afternoon:** something practical, one chapter
                3. **Evening:** something pleasurable, until sleepy

                The categories blur. The habit does not.

                ## The number is not the point

                Last year I read twenty-nine books. The year before, eleven. The difference was not effort; it was that I stopped treating reading as a performance and started treating it as the default thing to do with a quiet moment.

                That is the whole method. Put a book where the phone would be.
                MD,
            ],
            [
                'title' => 'Designing with restraint',
                'slug' => 'designing-with-restraint',
                'category' => 'design',
                'author' => $designer,
                'tags' => ['craft', 'typography', 'design'],
                'excerpt' => 'The hardest design decision is usually the second colour, the third font and the extra section.',
                'views' => 598,
                'days' => 44,
                'body' => <<<'MD'
                A page is finished when there is nothing left to remove. Most of us stop much earlier, when there is nothing left to add.

                Restraint is not minimalism as a style. It is the discipline of asking what each element is doing, and deleting the ones that cannot answer.

                ## The second colour

                One accent colour, used sparingly, feels intentional. Two accent colours start to argue. Three and the page has no point of view.

                The same is true of fonts, border radii, shadows and button styles. Every extra variant asks the reader to learn a new rule.

                ## Space is a feature

                White space is not empty. It is the thing that tells the eye where to go next. A dense page can be beautiful, but only if the density is the point.

                - Give headings room above, not just below
                - Let images breathe to the edge of the grid
                - Resist filling every gap with a card

                > If a section needs a border, a background and a shadow to be noticed, it probably does not need to be noticed.

                ## Decide once

                The most useful design document is a short list of decisions you will not revisit:

                1. Two typefaces, one accent colour
                2. Three spacing steps for vertical rhythm
                3. One card style, one button style, one link style
                4. No animation longer than 200ms

                Write it down. Future you will be tired and tempted.

                ## Edit the page like a sentence

                Read the layout the way you read a paragraph. Where does your eye snag? What is repeated? What could be cut without losing meaning?

                Then cut it. The page will feel quieter. Quiet is not the same as empty.
                MD,
            ],
            [
                'title' => 'What AI actually changed about my workflow',
                'slug' => 'what-ai-changed-workflow',
                'category' => 'technology',
                'author' => $admin,
                'tags' => ['ai', 'productivity', 'tools'],
                'excerpt' => 'Less than the demos promised, more than I expected. A year of notes on where the tools help and where they do not.',
                'views' => 1904,
                'days' => 52,
                'body' => <<<'MD'
                I have been using AI tools daily for about a year. Not as a novelty, but as part of the work: writing, coding, planning, reading. This is an attempt at an honest ledger.

                ## Where it genuinely helps

                **Boilerplate with a shape.** Migrations, form requests, test scaffolding — the kind of code where the structure is obvious and the details are tedious. I review it, but I no longer type it from scratch.

                **First drafts of prose.** Not final prose. A first draft is a way to get past the blank page, and a machine is very good at being unembarrassed by the blank page.

                **Explaining unfamiliar code.** Asking "what is this doing and what would break if I removed it" is faster than reading three files.

                **Naming things.** A small, real joy. Ten options in a second, one of which is not terrible.

                ## Where it fails

                - **Judgement.** It will confidently choose the wrong trade-off.
                - **Context.** It does not know your users, your history or your constraints.
                - **Taste.** The output is plausible, which is not the same as good.
                - **Truth.** Citations, APIs and edge cases need verification, always.

                > The tool is a very fast intern with no memory of yesterday and no stake in the outcome.

                ## The workflow that stuck

                My loop is now:

                1. Think on paper first. Always.
                2. Ask for a draft or a skeleton.
                3. Rewrite it until it sounds like a person.
                4. Test the parts that touch reality.
                5. Keep the diff small.

                The thinking did not get outsourced. If anything, it got more important, because the cost of generating plausible nonsense is now close to zero.

                ## The uncomfortable part

                The skills that feel most replaceable are the ones I spent the least time valuing: formatting, boilerplate, transcription. The skills that feel most valuable are the ones that were always hard to teach: knowing what to build, what to leave out, and when to stop.

                A year in, the honest summary is this: the tools made me faster at the parts I did not enjoy, and no faster at the parts that matter. That is still a good trade — as long as I am honest about which is which.
                MD,
            ],
            [
                'title' => 'Notes from a week offline',
                'slug' => 'notes-from-a-week-offline',
                'category' => 'culture',
                'author' => $admin,
                'tags' => ['slow-web', 'writing', 'remote-work'],
                'excerpt' => 'Seven days without a feed. The silence was not the interesting part — the return was.',
                'views' => 1103,
                'days' => 61,
                'body' => <<<'MD'
                I did not go anywhere. I stayed home, kept working, and turned off the parts of the internet that ask for something every few minutes.

                No social feeds. No news. No notifications. Email twice a day. Messages from actual humans, answered.

                ## The first two days

                The first day felt like a room with the furniture removed. I reached for my phone forty times before lunch and found nothing to open. By the afternoon I had reorganised a cupboard, which is what hands do when the mind is bored.

                The second day was worse. Not withdrawal exactly, but a low hum of missing out. Somewhere, a conversation was happening without me.

                It passed.

                ## What filled the space

                - Longer walks, without a podcast
                - A book read in three sittings instead of three weeks
                - Two conversations that went past the practical
                - A stubborn bug solved by staring out of a window

                None of this is a revelation. It is just what attention feels like when it is not being sliced.

                > Boredom is the apprenticeship for noticing.

                ## The work did not suffer

                This surprised me. I expected to fall behind. Instead the work got quieter and, by most measures, better. Fewer tabs, fewer context switches, fewer opinions absorbed before I had formed my own.

                The exception was coordination. Some things genuinely need a fast loop. I learned to batch those into two windows rather than living inside them.

                ## The return

                Coming back was the real experiment. The feeds were exactly as I left them: louder, faster, certain about things that will not matter tomorrow.

                I did not quit them. I did change three defaults:

                1. Notifications off, permanently, for everything that is not a person
                2. A reading window instead of a scrolling habit
                3. One day a week with no feeds at all

                The week offline did not teach me that the internet is bad. It taught me that my attention is finite, and that defaults decide where it goes.

                Set the defaults on purpose. Then go for a walk.
                MD,
            ],
            [
                'title' => 'The tools we keep coming back to',
                'slug' => 'tools-we-keep-coming-back-to',
                'category' => 'technology',
                'author' => $admin,
                'tags' => ['tools', 'productivity'],
                'excerpt' => 'A draft about the small, unglamorous tools that survive every new stack.',
                'views' => 0,
                'status' => 'draft',
                'body' => <<<'MD'
                Every few years the toolbox gets replaced. New editor, new notes app, new task manager. And yet a handful of tools survive every purge.

                This is a draft — notes toward an essay about the ones that stick.
                MD,
            ],
        ];

        foreach ($posts as $data) {
            $post = Post::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $data['author']->id,
                    'category_id' => $categories[$data['category']] ?? null,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'featured_image' => 'images/covers/'.$data['slug'].'.svg',
                    'status' => $data['status'] ?? 'published',
                    'is_featured' => $data['featured'] ?? false,
                    'views' => $data['views'] ?? 0,
                    'published_at' => isset($data['days']) ? now()->subDays($data['days'])->setTime(9, 30) : null,
                ]
            );

            $post->tags()->sync(
                collect($data['tags'] ?? [])->map(fn ($tag) => $tags[$tag] ?? null)->filter()->all()
            );
        }
    }
}
