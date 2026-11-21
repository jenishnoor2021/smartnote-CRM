@extends('layouts.front')

@section('title', 'Services - SMART NOTES PUBLICATION PVT. LTD.')

@section('page_style')
<link rel="stylesheet" href="{{ asset('assets/css/sn-services.css') }}">
@endsection

@section('content')
<main class="sn-services">

<!--==============================
    Breadcrumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-4.png') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Our Services</h1>
            <div class="breadcumb-menu-wrap">
                <div class="breadcumb-menu">
                    <span><a href="{{ url('/') }}">Home</a></span>
                    <span>Our Services</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="space-top space-bottom" id="service-intro">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <img
                    alt="Smart Notes Publication educational books"
                    class="img-fluid rounded shadow-sm"
                    src="{{ asset('assets/img/about/about-us-img1.png') }}"
                />
            </div>
            <div class="col-lg-8">
                <div class="title-area">
                    <span class="sec-subtitle"><i aria-hidden="true" class="fa-solid fa-book-open"></i> Our Services</span>
                    <h2 class="sec-title">Empowering Schools, Supporting Teachers &amp; Inspiring Students</h2>
                    <p class="lead">
                        <strong>Smart Notes Publication – Your Trusted Partner in Educational Excellence</strong>
                    </p>
                </div>
                <p>
                    At Smart Notes Publication, we believe that quality education requires more than just textbooks.
                    That's why we offer a complete range of educational publishing and academic support services
                    designed to simplify school management, reduce teachers' planning workload, and enhance students'
                    learning experiences.
                </p>
                <p>
                    From carefully designed educational books to subject-wise worksheets, structured annual planners,
                    chapter-based assignments, and convenient book delivery, our solutions help schools stay organized
                    and teachers focus on what matters most —
                    <strong>teaching, guiding, and inspiring students.</strong>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Services Grid from Admin Panel -->
<div class="container sn-services-grid">
  @forelse($services as $index => $service)
    <section class="space-top space-bottom wow animate__fadeInUp" data-wow-delay="{{ 0.05 + ($index * 0.05) }}s" id="service-section-{{ $service->id }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area mb-4">
                        <span class="sec-subtitle">Service {{ sprintf('%02d', $index + 1) }} / Smart Notes Publication</span>
                        <h2 class="sec-title">
                            <i aria-hidden="true" class="{{ $service->icon ?? 'fa-solid fa-book-open' }} text-primary me-2"></i>
                            {{ $service->title }}
                        </h2>
                        @if($service->short_description)
                            <p class="lead">{{ $service->short_description }}</p>
                        @endif
                    </div>

                    <details class="sn-service-details" open>
                        <summary>View details &amp; benefits</summary>
                        <div class="publication-content">
                            @if($service->content)
                                <p class="mb-3" style="font-size: 16px; line-height: 1.8; color: #4b5563;">
                                    {!! nl2br(e($service->content)) !!}
                                </p>
                            @endif

                            @php
                                $featuresList = $service->features_list;
                            @endphp
                            @if(!empty($featuresList) && count($featuresList) > 0)
                                <h3 class="h4 mt-4 mb-3">Key Benefits &amp; Features</h3>
                                <ul class="row row-cols-1 row-cols-md-2 g-3 ps-0 list-unstyled">
                                    @foreach($featuresList as $feat)
                                        <li class="col">
                                            <div class="h-100 p-4 bg-white border rounded shadow-sm">
                                                <i aria-hidden="true" class="fa-solid fa-circle-check text-primary me-2"></i>{{ $feat }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>
  @empty
    <div class="text-center py-5">
        <p class="text-muted">No services currently listed. Please check back later.</p>
    </div>
  @endforelse
</div>
<section class="space-top space-bottom" id="service-contact">
    <div class="container text-center">
        <div class="title-area">
            <span class="sec-subtitle">Let's Make Teaching Easier Together!</span>
            <h2 class="sec-title">Partner with Smart Notes Publication for Smarter Academic Solutions.</h2>
            <p>
                Discover educational books and academic support services designed to simplify teaching, support school
                management, and inspire confident learning.
            </p>
        </div>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a class="vs-btn" href="{{ url('contact') }}"><i class="fa-solid fa-comments me-2" aria-hidden="true"></i>Contact Us Today</a>
			<!-- <a class="vs-btn" href="{{ url('pre-primary-english-premium-set') }}">Explore Our Books</a>
			<a class="vs-btn" href="{{ url('contact') }}">Become Our School Partner</a> -->
        </div>
    </div>
</section>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="title-area text-center">
                    <span class="sec-subtitle">Helpful Answers</span>
                    <h2 class="sec-title">Frequently Asked Questions</h2>
                </div>
                <div class="accordion" id="publicationFaq">
                  <div class="sn-faq-column">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-0">
                            <button
                                aria-controls="faq-answer-0"
                                aria-expanded="true"
                                class="accordion-button"
                                data-bs-target="#faq-answer-0"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                1. What is Smart Notes Publication?
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
                                    Smart Notes Publication is an educational book publishing company in India
                                    specializing in school textbooks, children's books, academic workbooks, preschool
                                    learning materials, and educational resources. The company focuses on making
                                    education engaging, accessible, and effective for students and educators.
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
                                2. What types of educational books does Smart Notes Publication publish?
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
                                    Smart Notes Publication offers a wide range of educational books, including English,
                                    Mathematics, Science, Environmental Studies, Hindi, Gujarati, General Knowledge,
                                    English Grammar, Value Education, Art &amp; Craft, Phonics, handwriting, and
                                    activity-based learning books.
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
                                3. Does Smart Notes Publication provide books for preschool and kindergarten students?
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
                                    Yes. Smart Notes Publication offers educational books and learning materials for
                                    Play Group, Nursery, Junior KG, and Senior KG students. These books focus on
                                    foundational literacy, numeracy, language development, creativity, and early
                                    childhood learning.
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
                                4. Are Smart Notes Publication books available for primary and middle school students?
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
                                    Yes. Smart Notes Publication provides educational resources for students from
                                    preschool through Class 8, covering various academic subjects and learning
                                    requirements.
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
                                5. Does Smart Notes Publication offer English and Gujarati medium books?
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
                                    Yes. Smart Notes Publication offers educational books for English and Gujarati
                                    medium students, helping schools and learners access suitable academic resources
                                    according to their language requirements.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-5">
                            <button
                                aria-controls="faq-answer-5"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-5"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                6. What makes Smart Notes Publication different from other educational publishers?
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
                                    Smart Notes Publication emphasizes student-friendly content, structured lessons,
                                    engaging illustrations, activity-based learning, quality book production, and
                                    digital educational support. Its goal is to make academic concepts easier to
                                    understand and learning more enjoyable.
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
                                7. Are Smart Notes Publication books based on modern educational approaches?
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
                                    Smart Notes Publication incorporates activity-based and concept-focused learning
                                    approaches in its educational materials. Its publishing philosophy also reflects
                                    principles associated with NEP 2020 and NCF 2023, including experiential learning,
                                    foundational skills, and student participation.
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
                                8. Does Smart Notes Publication provide QR code-based digital learning support?
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
                                    Smart Notes Publication offers digital educational resources, including animated
                                    learning videos and interactive activities. Selected publications and learning
                                    programs may provide QR code-based access to supplementary digital content.
                                </p>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="sn-faq-column">
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
                                9. Can schools and educational institutions enquire about bulk book requirements?
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
                                    Yes. Schools, educational institutions, bookstores, and distributors can contact
                                    Smart Notes Publication to enquire about educational book collections, availability,
                                    quantities, and institutional requirements.
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
                                10. Does Smart Notes Publication offer activity-based learning books?
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
                                    Yes. Smart Notes Publication develops educational materials that include interactive
                                    exercises, illustrations, practical activities, creative assignments, and learning
                                    games to encourage active participation.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-10">
                            <button
                                aria-controls="faq-answer-10"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-10"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                11. Why are activity-based educational books important for children?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-10"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-10"
                        >
                            <div class="accordion-body">
                                <p>
                                    Activity-based educational books encourage children to participate in the learning
                                    process. They can support conceptual understanding, problem-solving, creativity,
                                    observation, and the practical application of academic knowledge.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-11">
                            <button
                                aria-controls="faq-answer-11"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-11"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                12. How can I choose the right educational books for my school?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-11"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-11"
                        >
                            <div class="accordion-body">
                                <p>
                                    Start by identifying the students' academic levels, subjects, medium of instruction,
                                    curriculum requirements, and learning objectives. You can then explore Smart Notes
                                    Publication's book categories and contact the team for further product information.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-12">
                            <button
                                aria-controls="faq-answer-12"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-12"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                13. Does Smart Notes Publication provide Mathematics and English Grammar books?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-12"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-12"
                        >
                            <div class="accordion-body">
                                <p>
                                    Yes. Smart Notes Publication offers Mathematics and English Grammar books designed
                                    to strengthen foundational knowledge, improve subject understanding, and provide
                                    structured opportunities for practice.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-13">
                            <button
                                aria-controls="faq-answer-13"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-13"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                14. What are the benefits of using Smart Notes Publication's preschool books?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-13"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-13"
                        >
                            <div class="accordion-body">
                                <p>
                                    Smart Notes Publication's preschool books use age-appropriate lessons, colorful
                                    illustrations, interactive exercises, and creative activities to support early
                                    literacy, numeracy, language development, and foundational learning.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="faq-heading-14">
                            <button
                                aria-controls="faq-answer-14"
                                aria-expanded="false"
                                class="accordion-button collapsed"
                                data-bs-target="#faq-answer-14"
                                data-bs-toggle="collapse"
                                type="button"
                            >
                                15. How can I contact Smart Notes Publication for educational book enquiries?
                            </button>
                        </h3>
                        <div
                            aria-labelledby="faq-heading-14"
                            class="accordion-collapse collapse"
                            data-bs-parent="#publicationFaq"
                            id="faq-answer-14"
                        >
                            <div class="accordion-body">
                                <p>
                                    You can contact Smart Notes Publication through its official website or customer
                                    enquiry channels for information about available books, educational collections, and
                                    school requirements.
                                </p>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
@endsection

@section('page_script')
@endsection
