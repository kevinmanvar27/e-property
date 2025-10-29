@extends('user.layouts.app')

@section('content')
<div class="container-fluid bg-primary text-white py-5 shadow-sm">
  <div class="container">
    <h1 class="display-5 fw-bold">Frequently Asked Questions</h1>
    <p class="text-light mb-0">Learn more about how RProperty works</p>
  </div>
</div>

<div class="container my-5">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-5">
      <p class="mb-4">
        Welcome to <strong>RProperty</strong> — a digital platform for brokers and property owners to display property details online.<br>
        We do not buy or sell properties directly; our goal is to help users discover relevant property information in one place.
      </p>

      <div class="accordion" id="faqAccordion">

        <!-- FAQ 1 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingOne">
            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
              What is RProperty?
            </button>
          </h2>
          <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p><strong>RProperty</strong> is an online platform that helps real estate brokers and property owners showcase listings, including land, houses, plots, sheds, and shops. We serve only as a display website — we do <strong>not</strong> directly handle any transactions for buying, selling, or renting.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 2 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingTwo">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
              Can I buy or sell property through RProperty?
            </button>
          </h2>
          <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>No. RProperty is not a buying/selling platform. We allow brokers or owners to upload property details for public viewing. Any property deal or transaction happens privately, outside the RProperty site.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 3 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingThree">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
              Who can list properties on RProperty?
            </button>
          </h2>
          <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>Verified real estate brokers, agents, or authorized property owners may list properties. Each listing must follow our guidelines and include all required details for accuracy and transparency.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 4 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingFour">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
              Does RProperty verify property details?
            </button>
          </h2>
          <div id="faqFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>RProperty reviews listings for completeness and clarity, but we do <strong>not</strong> verify ownership, legal status, or pricing. It is each user's responsibility to check and validate property information with the advertiser before making decisions.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 5 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingFive">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
              Is there any charge for listing properties?
            </button>
          </h2>
          <div id="faqFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>Property listing may be free or paid, depending on your plan. Premium listings are promoted for greater visibility. For the latest pricing, please contact our team at <a href="mailto:support@rproperty.com" class="text-decoration-none text-primary">support@rproperty.com</a>.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 6 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingSix">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqSix" aria-expanded="false" aria-controls="faqSix">
              How is my information protected?
            </button>
          </h2>
          <div id="faqSix" class="accordion-collapse collapse" aria-labelledby="faqHeadingSix" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>Your data is secured under our <a href="{{ url('privacy-policy') }}" class="text-decoration-none text-primary">Privacy Policy</a> with SSL encryption and secure hosting. We do not sell your information and take all reasonable measures to protect your privacy.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 7 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingSeven">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqSeven" aria-expanded="false" aria-controls="faqSeven">
              How do I contact RProperty for support?
            </button>
          </h2>
          <div id="faqSeven" class="accordion-collapse collapse" aria-labelledby="faqHeadingSeven" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>For help or questions, email <a href="mailto:support@rproperty.com" class="text-decoration-none text-primary">support@rproperty.com</a> or use the <a href="{{ url('contact') }}" class="text-decoration-none text-primary">Contact Us</a> page on our website.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 8 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingEight">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqEight" aria-expanded="false" aria-controls="faqEight">
              Can RProperty remove or block listings?
            </button>
          </h2>
          <div id="faqEight" class="accordion-collapse collapse" aria-labelledby="faqHeadingEight" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>Yes, RProperty reserves the right to edit, block, or remove property listings that violate our guidelines or terms of use. Such actions are taken to maintain quality and protect users.</p>
            </div>
          </div>
        </div>

        <!-- FAQ 9 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faqHeadingNine">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqNine" aria-expanded="false" aria-controls="faqNine">
              What should I do if I suspect fraud or incorrect details?
            </button>
          </h2>
          <div id="faqNine" class="accordion-collapse collapse" aria-labelledby="faqHeadingNine" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              <p>If you spot fraudulent listings or inaccurate details, please report them immediately via email to <a href="mailto:support@rproperty.com" class="text-decoration-none text-primary">support@rproperty.com</a>. We appreciate your assistance in keeping our site safe and reliable.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
