@extends('layouts.front')

@section('title', 'Book Publisher - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<link rel="stylesheet" href="{{ asset('assets/css/sn-book-publication.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/sn-book-publisher.css') }}">
@endsection

@section('content')
<main class="sn-publication sn-publisher">

<!--==============================
    Breadcrumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg-4.png">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">SmartNotes Publication</h1>
            <div class="breadcumb-menu-wrap">
                <div class="breadcumb-menu">
                    <span><a href="{{ url('/') }}">Home</a></span>
                    <span>Book Publishing House</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sn-page">
    <section id="sn-section-1">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-book-open me-2"></i> SmartNotes Publication</span>
            <h2>SmartNotes Publication: Your Trusted Educational Book Publisher in India</h2>
            <p>Empowering Young Minds Through Quality Education and Innovative Learning Resources</p>
            <div class="sn-publisher-intro"><p>
                At SmartNotes Publication, we believe that every child deserves access to quality education and
                thoughtfully designed learning materials. As an educational publishing house in India, we are committed
                to creating engaging, informative, and age-appropriate books that help students build strong academic
                foundations.
            </p>
            <p>
                From early childhood education to primary and middle school learning, our educational books are designed
                to simplify complex concepts, encourage curiosity, develop essential skills, and make learning an
                enjoyable experience.
            </p>
            <p>
                Our diverse collection includes textbooks, practice workbooks, general knowledge books, English grammar
                books, mathematics books, language learning resources, and creative activity books.
            </p>
            <p>
                With a strong focus on quality content, innovative teaching methodologies, attractive illustrations, and
                student-friendly presentation, SmartNotes Publication strives to become a dependable educational partner
                for schools, teachers, parents, and students.
            </p></div>
        </div>
    </section>
    
<section id="sn-section-2">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-graduation-cap me-2"></i> SmartNotes Publication</span>
            <h2>Why Choose SmartNotes Publication?</h2>
            <div class="sn-publisher-panels"><details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-book-open"></i><h3 class="sn-publisher-heading">1. Comprehensive Educational Publishing Solutions</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>
                SmartNotes Publication offers a wide range of educational books and academic learning resources designed
                to meet the evolving needs of modern education.
            </p>
            <p>
                Our publishing approach combines carefully structured academic content with creative learning techniques
                to help students understand concepts effectively.
            </p>
            <div class="row g-3 my-3">
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-book-open"></i>
                        <p>
                            <strong>School Textbooks:</strong> Well-organized, subject-wise books designed to support
                            classroom learning.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-graduation-cap"></i>
                        <p>
                            <strong>Practice Workbooks:</strong> Engaging exercises and revision activities to
                            strengthen conceptual understanding.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-lightbulb"></i>
                        <p>
                            <strong>Early Childhood Learning:</strong> Interactive educational materials for preschool,
                            nursery, Junior KG, and Senior KG students.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-palette"></i>
                        <p>
                            <strong>Subject-Specific Resources:</strong> Mathematics, English, Hindi, Gujarati, General
                            Knowledge, and other essential subjects.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-laptop"></i>
                        <p>
                            <strong>Creative Learning Materials:</strong> Drawing, colouring, handwriting, storytelling,
                            and activity-based books.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-school"></i>
                        <p>
                            <strong>Educational Support Resources:</strong> Learning materials designed to assist
                            teachers and parents in supporting children's development.
                        </p>
                    </div>
                </div>
            </div>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-lightbulb"></i><h3 class="sn-publisher-heading">2. Student-Centric Learning Approach</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>We believe effective education begins with understanding how children learn.</p>
            <p>
                Our educational books focus on simplifying complex topics through clear explanations, colourful
                illustrations, practical examples, and thoughtfully designed activities.
            </p>
            <p>Our learning approach emphasizes:</p>
            <div class="row g-3 my-3">
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-book-open"></i>
                        <p>Easy-to-understand concepts and explanations.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-graduation-cap"></i>
                        <p>Age-appropriate educational content.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-lightbulb"></i>
                        <p>Interactive exercises and practice activities.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-palette"></i>
                        <p>Logical thinking and problem-solving skills.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-laptop"></i>
                        <p>Creativity, curiosity, and independent learning.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-school"></i>
                        <p>Continuous improvement through revision and assessment.</p>
                    </div>
                </div>
            </div>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-graduation-cap"></i><h3 class="sn-publisher-heading">3. Curriculum-Oriented Educational Content</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>
                SmartNotes Publication recognizes the importance of structured learning aligned with modern educational
                requirements.
            </p>
            <p>
                Our books are developed with attention to learning objectives, subject progression, conceptual clarity,
                and practical understanding.
            </p>
            <p>
                We aim to support contemporary educational approaches, including the principles of NEP 2020 and NCF
                2023, through activity-based learning, foundational literacy, numeracy, and skill development.
            </p>
            <p>
                Our goal is to help educators create meaningful classroom experiences while encouraging students to
                become confident and independent learners.
            </p>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-palette"></i><h3 class="sn-publisher-heading">4. Quality Publishing and Attractive Book Design</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>A well-designed educational book can transform the learning experience.</p>
            <p>
                At SmartNotes Publication, we focus on creating visually appealing and academically meaningful learning
                materials that encourage students to explore, understand, and practise.
            </p>
            <p>Our books emphasize:</p>
            <div class="row g-3 my-3">
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-book-open"></i>
                        <p>Colourful and engaging illustrations.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-graduation-cap"></i>
                        <p>Clear typography and organized page layouts.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-lightbulb"></i>
                        <p>High-quality printing and presentation.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-palette"></i>
                        <p>Child-friendly educational activities.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-laptop"></i>
                        <p>Structured chapters and progressive exercises.</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-school"></i>
                        <p>Durable and practical book formats.</p>
                    </div>
                </div>
            </div>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-qrcode"></i><h3 class="sn-publisher-heading">5. Innovative Digital Learning Support</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>Blending Traditional Education with Modern Technology</p>
            <p>SmartNotes Publication believes that learning should extend beyond printed textbooks.</p>
            <p>
                Our educational offerings include digital learning resources designed to complement classroom
                instruction and support interactive learning experiences. The company's published materials describe
                animated educational videos, teacher-recorded learning content, and game-based digital activities.
            </p>
            <p>Key areas of digital learning support include:</p>
            <div class="row g-3 my-3">
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-book-open"></i>
                        <p>
                            <strong>QR Code-Based Learning:</strong> Connecting printed learning materials with
                            supplementary digital content where available.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-graduation-cap"></i>
                        <p>
                            <strong>Animated Educational Videos:</strong> Helping children understand concepts through
                            visual explanations.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-lightbulb"></i>
                        <p>
                            <strong>Interactive Digital Activities:</strong> Encouraging participation through
                            educational games and activities.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-palette"></i>
                        <p>
                            <strong>Concept-Based Learning Support:</strong> Reinforcing important lessons through
                            engaging digital resources.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-laptop"></i>
                        <p>
                            <strong>Learn, Play &amp; Grow:</strong> Combining creativity, exploration, and educational
                            activities for meaningful learning.
                        </p>
                    </div>
                </div>
            </div>
            <p>
                QR code access and digital features should be described on individual product pages according to the
                features actually included with each book.
            </p>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-language"></i><h3 class="sn-publisher-heading">6. English and Gujarati Medium Learning Resources</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>Language plays an essential role in making education accessible and meaningful.</p>
            <p>
                SmartNotes Publication offers educational resources for English and Gujarati medium students, helping
                schools and families choose learning materials suited to their educational requirements.
            </p>
            <p>
                Our language-focused resources aim to develop reading comprehension, vocabulary, grammar, writing
                skills, communication, and confidence.
            </p>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-school"></i><h3 class="sn-publisher-heading">7. Supporting Schools, Teachers, and Parents</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>
                We understand that quality education is a collaborative effort involving students, educators, schools,
                and families.
            </p>
            <p>
                SmartNotes Publication strives to support this partnership by providing practical and engaging
                educational materials.
            </p>
            <p>
                For schools, our books support organized classroom teaching. For teachers, they provide activities and
                exercises that can complement lesson planning. For parents, our learning materials offer opportunities
                to reinforce concepts through guided practice at home.
            </p>
        </div></details></div></div>
    </section>
    <section id="sn-section-3">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-lightbulb me-2"></i> SmartNotes Publication</span>
            <h2>Explore Our Educational Book Collection</h2>
            <div class="sn-publisher-collection"><article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-child-reaching"></i><div class="sn-feature"><p>1. Pre-Primary and Kindergarten Books</p></div>
            <p>
                Our preschool learning resources introduce children to foundational concepts through pictures, stories,
                activities, and playful exercises. Designed for Play Group, Nursery, Junior KG, and Senior KG, these
                books support early literacy, numeracy, creativity, and cognitive development.
            </p></article>
<article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-calculator"></i><div class="sn-feature"><p>2. Mathematics and Practice Workbooks</p></div>
            <p>
                Our mathematics books encourage logical thinking, number recognition, calculation skills, and
                problem-solving through progressive exercises and practical examples. They help students practise
                concepts and develop confidence in mathematics.
            </p></article>
<article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-language"></i><div class="sn-feature"><p>3. English Grammar and Language Books</p></div>
            <p>
                Our language learning materials focus on grammar, vocabulary, sentence formation, reading comprehension,
                and writing skills. Structured lessons and engaging exercises encourage clear communication and language
                development.
            </p></article>
<article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-globe"></i><div class="sn-feature"><p>4. General Knowledge and Environmental Learning</p></div>
            <p>
                Our General Knowledge and environmental learning books introduce students to the world around them.
                Through informative illustrations, interesting topics, and interactive activities, students develop
                observation skills, curiosity, and general awareness.
            </p></article>
<article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-palette"></i><div class="sn-feature"><p>5. Art, Craft, and Creative Activity Books</p></div>
            <p>
                Creativity is an important part of childhood development. Our drawing, colouring, craft, and activity
                books encourage imagination, fine motor skills, visual expression, and creative confidence.
            </p></article>
<article class="sn-publisher-collection-card"><i aria-hidden="true" class="fa-solid fa-book-open"></i><div class="sn-feature"><p>6. Value Education, Rhymes, and Storybooks</p></div>
            <p>
                Our value education and storytelling resources encourage positive habits, social awareness, imagination,
                and emotional development. Stories, rhymes, and meaningful activities help children learn important life
                lessons.
            </p></article></div>
        </div>
    </section>
    <section id="sn-section-4">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-palette me-2"></i> SmartNotes Publication</span>
            <h2>SmartNotes Publication: Inspiring Learning, Building Brighter Futures</h2>
            <div class="sn-publisher-panels"><details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-eye"></i><h3 class="sn-publisher-heading">Our Vision</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>
                To become a trusted name in educational publishing by providing innovative, accessible, and high-quality
                learning resources that inspire curiosity, strengthen academic foundations, and empower every child to
                achieve their potential.
            </p>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-bullseye"></i><h3 class="sn-publisher-heading">Our Mission</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <p>
                Our mission is to make education simple, engaging, and meaningful through thoughtfully developed books
                and modern learning solutions.
            </p>
            <p>
                We aim to support schools and educators with effective teaching resources while helping students develop
                knowledge, confidence, creativity, and essential life skills.
            </p>
            </div></details>
<details class="sn-publisher-panel"><summary><i aria-hidden="true" class="fa-solid fa-heart"></i><h3 class="sn-publisher-heading">Our Core Values</h3><span class="sn-publisher-plus" aria-hidden="true">+</span></summary><div class="sn-publisher-panel-body">
            <div class="row g-3 my-3">
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-book-open"></i>
                        <p>
                            <strong>Quality Education:</strong> Maintaining high standards in educational content and
                            book development.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-graduation-cap"></i>
                        <p>
                            <strong>Innovation:</strong> Encouraging modern, interactive, and creative learning
                            approaches.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-lightbulb"></i>
                        <p>
                            <strong>Accessibility:</strong> Making meaningful educational resources available to diverse
                            learners.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-palette"></i>
                        <p>
                            <strong>Academic Excellence:</strong> Supporting strong conceptual understanding and
                            continuous improvement.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-laptop"></i>
                        <p>
                            <strong>Student Development:</strong> Encouraging intellectual, emotional, and creative
                            growth.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4" data-wow-delay="0.1s">
                    <div class="sn-card h-100">
                        <i aria-hidden="true" class="fa-solid fa-school"></i>
                        <p>
                            <strong>Educational Partnership:</strong> Building meaningful relationships with schools,
                            teachers, parents, and distributors.
                        </p>
                    </div>
                </div>
            </div>
        </div></details></div></div>
    </section>
    <section id="sn-section-5">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-laptop me-2"></i> SmartNotes Publication</span>
            <h2>Our Educational Publishing Process</h2>
            <p>We follow a structured approach to creating meaningful learning resources.</p>
            <div class="sn-publisher-process"><article class="sn-publisher-step"><h3 class="sn-publisher-heading">1</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Educational Research &amp; Planning</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Identifying learning needs, educational objectives, and subject requirements.</p></article>
            <article class="sn-publisher-step"><h3 class="sn-publisher-heading">2</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Content Development</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Preparing age-appropriate lessons, explanations, activities, and exercises.</p></article>
            <article class="sn-publisher-step"><h3 class="sn-publisher-heading">3</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Academic Review &amp; Editing</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Reviewing educational content for clarity, accuracy, and consistency.</p></article>
            <article class="sn-publisher-step"><h3 class="sn-publisher-heading">4</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Creative Design &amp; Illustration</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Developing engaging layouts, illustrations, and child-friendly visual elements.</p></article>
            <article class="sn-publisher-step"><h3 class="sn-publisher-heading">5</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Printing &amp; Quality Review</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Preparing finished books with attention to presentation, readability, and print quality.</p></article>
            <article class="sn-publisher-step"><h3 class="sn-publisher-heading">6</h3>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Distribution &amp; Educational Support</p>
            <p><i class="fa-regular fa-circle-right pe-2"></i>Making educational resources available to schools, educators, distributors, and learners.</p></article></div>
        </div>
    </section>

    <section id="sn-section-6">
        <div class="container position-relative">
            <span class="sn-eyebrow"><i class="fa-solid fa-school me-2"></i> SmartNotes Publication</span>
            <h2>Frequently Asked Questions</h2>
            <div class="accordion" id="publicationFaq">
                    <div class="sn-faq-column"><div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-0">
                            <button
                                aria-controls="faq-answer-0"
                                aria-expanded="true"
                                class="accordion-button"
                                data-bs-target="#faq-answer-0"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                1. What is SmartNotes Publication?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-0"
                            class="accordion-collapse collapse show"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-0"
                        >
                            <div class="accordion-body">
                                <p>
                                    SmartNotes Publication is an educational publishing house dedicated to providing high-quality, innovative, and engaging learning resources for students and schools. We specialize in developing thoughtfully designed educational books, workbooks, and activity-based learning materials that make education simple, interactive, and enjoyable. Our mission is to inspire young minds, strengthen academic foundations, and support teachers and students through modern educational solutions.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-1">
                            <button
                                aria-controls="faq-answer-1"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-1"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                2. Which educational books does SmartNotes Publication offer?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-1"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-1"
                        >
                            <div class="accordion-body">
                                <p>
                                    SmartNotes Publication offers a wide range of educational books, including English, Mathematics, Science and Environmental Studies (EVS), General Knowledge, English Grammar, Hindi, Gujarati, Value Education, Phonics, Rhymes and Stories, Handwriting, Drawing, Art & Craft, and activity-based workbooks. Our learning resources are designed to develop essential academic skills, creativity, logical thinking, and practical knowledge among students
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-2">
                            <button
                                aria-controls="faq-answer-2"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-2"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                3. Does SmartNotes Publication provide books for preschool students?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-2"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-2"
                        >
                            <div class="accordion-body">
                                <p>
                                    Yes, SmartNotes Publication offers a specially designed collection of preschool educational books for Nursery, Junior KG (LKG), and Senior KG (UKG) students. Our preschool books feature colorful illustrations, engaging activities, rhymes, stories, alphabet learning, number recognition, phonics, and creative exercises. These age-appropriate resources help children develop early literacy, numeracy, communication, and cognitive skills while making learning a joyful experience.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-3">
                            <button
                                aria-controls="faq-answer-3"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-3"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                4. Are SmartNotes Publication books available for English and Gujarati medium schools?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-3"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-3"
                        >
                            <div class="accordion-body">
                                <p>
                                    Yes, SmartNotes Publication provides educational books suitable for both English and Gujarati medium schools. We offer language-appropriate learning materials designed to support students' understanding, reading, writing, and overall academic development. Our collection also includes Hindi learning resources, helping schools select educational materials according to their teaching requirements and language preferences
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-4">
                            <button
                                aria-controls="faq-answer-4"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-4"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                5. Does SmartNotes Publication offer digital learning support?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-4"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-4"
                        >
                            <div class="accordion-body">
                                <p>
                                    Yes, SmartNotes Publication supports modern education through digital learning resources, including animated educational videos, interactive learning activities, and game-based educational content. Our digital learning solutions are designed to complement printed books, improve concept understanding, encourage active participation, and make learning more engaging. Selected learning resources also offer app-based educational support, helping students learn both inside and outside the classroom.
                                </p>
                            </div>
                        </div>
                    </div></div><div class="sn-faq-column"><div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-5">
                            <button
                                aria-controls="faq-answer-5"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-5"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                6. What makes SmartNotes Publication different from other educational publishers?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-5"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-5"
                        >
                            <div class="accordion-body">
                                <p>
                                    SmartNotes Publication focuses on combining quality educational content with creative presentation, activity-based learning, and modern teaching approaches. Our books feature colorful illustrations, easy-to-understand explanations, practical exercises, and interactive activities that encourage curiosity and independent thinking. With an emphasis on conceptual clarity, skill development, and engaging learning experiences, we aim to make education more meaningful, accessible, and enjoyable for every student.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-6">
                            <button
                                aria-controls="faq-answer-6"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-6"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                7. Does SmartNotes Publication publish activity-based learning books?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-6"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-6"
                        >
                            <div class="accordion-body">
                                <p>
                                    Yes, SmartNotes Publication offers activity-based educational books and workbooks designed to promote learning through practice, exploration, and creativity. Our publications include interactive worksheets, puzzles, coloring activities, writing exercises, educational games, and skill-development tasks. These activities help strengthen problem-solving abilities, observation skills, hand-eye coordination, creativity, and logical thinking while encouraging students to participate actively in the learning process.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-7">
                            <button
                                aria-controls="faq-answer-7"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-7"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                8. Are SmartNotes Publication books suitable for school classroom teaching?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-7"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-7"
                        >
                            <div class="accordion-body">
                                <p>
                                   Yes, SmartNotes Publication books are designed to support classroom teaching, guided learning, and independent practice. Our educational resources include structured lessons, engaging illustrations, practice exercises, revision activities, and age-appropriate content that help teachers explain concepts effectively. Selected books also include suggested teaching approaches and assessment guidance, making them useful for classroom instruction, homework, revision, and overall academic development.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-8">
                            <button
                                aria-controls="faq-answer-8"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-8"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                9. How can schools and distributors inquire about educational books?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-8"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-8"
                        >
                            <div class="accordion-body">
                                <p>
                                   Schools, educational institutions, bookstores, and distributors can contact SmartNotes Publication directly to inquire about educational books, available series, product catalogs, bulk orders, and distribution opportunities. Our team can assist with information about book collections, pricing, order quantities, and educational requirements. For inquiries, please contact us by phone or email, or visit our official website to explore our educational publishing solutions.
                                </p>
                            </div>
                        </div>
                    </div>
<div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-9">
                            <button
                                aria-controls="faq-answer-9"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-9"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                10. How can I contact SmartNotes Publication?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-9"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-9"
                        >
                            <div class="accordion-body">
                                <p>
                                   You can contact SmartNotes Publication for educational book inquiries, school orders, distribution opportunities, and general assistance through our Surat Regional Office.</p>
								   <div class="vs-blog">
									   <div class="btn-area">
											<a class="vs-btn" href="{{ url('contact') }}">Contact Us<i class="fa-regular fa-arrow-right"></i></a>
									  </div>
								  </div>
                            </div>
                        </div>
                    </div></div>
                </div>
        </div>
    </section>
</div>

</main>
@endsection

@section('page_script')
@endsection
