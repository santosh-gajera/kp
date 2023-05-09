<?php

/*
 * Template Name: Presentation
 * Template Post Type: lessons
*/

new \Kapow\PresentationMode;
\Kapow\PresentationMode::init();

if (array_key_exists('iframe', $_GET) && $_GET['iframe'] == 'true') {
    global $post;
    if (!array_key_exists('id', $_GET)) return;
    if (!array_key_exists('type', $_GET)) return;
    header("Content-Security-Policy: frame-ancestors 'self'");
    $GLOBALS['iframe_presentation'] = true;
    get_header('presentation'); ?>

        <?php if ($_GET['type'] == 'presentation') { ?>
            <div class="lp-presentation">
                <div class="presentation-main-event">
                    <?php get_template_part('components/presentation/presentations', null, [
                        'presentationId' => intval($_GET['id']),
                        'lessonId'       => $post->ID,
                    ]); ?>
                </div>
            </div>
        <?php } elseif ($_GET['type'] == 'quiz') { ?>
            <div class="lp-presentation">
                <div class="presentation-main-event">
                    <?php get_template_part('components/presentation/presentations', null, [
                        'quizId'   => intval($_GET['id']),
                        'lessonId' => $post->ID,
                    ]); ?>
                </div>
            </div>
        <?php } ?>

        <style>
            /* .lp-presentation .presentations-quiz-slide__col-2 .quiz-slide__answer-type--true-false .quiz-slide__tf {
                width: 15rem;
                height: 15rem;
            } */

            .presentations {
                position: fixed !important;
                top: 0 !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 999;
                height: 100vh !important;
                width: 100% !important;
            }
            #wpadminbar {
                display: none !important;
            }
            .lp-presentation .presentations__slide {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .lp-presentation:not(.fullscreen) .presentations .container:not(.gallery__container) {
                max-width: unset !important;
                height: 100% !important;
                padding: 4rem !important;
            }

            .lp-presentation:not(.fullscreen) .presentations-quiz-slide__col-2 .quiz-slide__answer-type--true-false .quiz-slide__true, 
            .lp-presentation:not(.fullscreen) .presentations-quiz-slide__col-2 .quiz-slide__answer-type--true-false .quiz-slide__false {
                width: 13rem;
                height: 13rem;
            }

            .lp-presentation:not(.fullscreen) .presentation-transform {
                transform: scale(.8);
            }

            .lp-presentation:not(.fullscreen) .presentations-quiz-slide__col-wrapper {
                padding: 0;
            }

            .lp-presentation:not(.fullscreen) .presentations-quiz-slide__col-1 .quiz-slide__text-with-icon {
                padding: 2.5rem;
            }

            .lp-presentation:not(.fullscreen) .presentations-quiz-slide__col-wrapper.subject-colour .presentations-quiz-slide__question-count {
                margin-bottom: 0;
                padding: 2rem 0 0 3rem;
            }

            .lp-presentation.fullscreen .presentations-quiz-slide__col-wrapper {
                min-height: 35rem;
            }

            .lp-presentation:not(.fullscreen) .quiz-slide__video iframe {
                height: 13rem;
            }

            .lp-presentation:not(.fullscreen) .quiz-slide__audios-area .plyr__controls {
                width: fit-content;
            }

            .lp-presentation:not(.fullscreen) .quiz-slide__text-area .quiz-slide__text {
                font-size: inherit !important;
            }
        </style>

        <script>
        jQuery(document).ready(function($) {
            console.log('confetti lesson plan');
            //* Confetti animation
            function addConfetti(selector) {
                console.log('Confetti init');
                var myCanvas = document.createElement('canvas');
                selector.appendChild(myCanvas);
                
                var myConfetti = confetti.create(myCanvas, {
                    resize: true,
                    // useWorker: true
                });
                
                myConfetti({
                    particleCount: 200,
                    spread: 360,
                    origin: { y: 0.35 },
                    zIndex: 999999999999999,
                    startVelocity: 45,
                    gravity: .5
                });
            }
            //* Shoot confetti when user clicks on slides arrows
            $('body').on('click', '.presentations__footer', function(e) {
                console.log('Footer click');
                //* Get current slide number
                var slideNumber = $(e.currentTarget).find('[data-presentations-counter]').text();
                var tot = parseInt($('.presentations__slide')[1].getAttribute('data-tot-slides'));
                if (slideNumber == tot + 1) {
                    console.log('the slide');
                    $('body').on('click', '.presentations__next.active', function(e) {
                        var theElement = $(e.currentTarget).parents('.presentations__quiz-main').find('.confetti-wrapper')[0];
                        addConfetti(theElement);
                    });
                }
            });

            //* Shoot confetti when user clicks on see results button
            $('body').on('click', '.quiz-slide__next', function(e) {
                console.log('Next click');
                //* Get current slide number
                var slideNumber = $(e.currentTarget).parents('.presentations__quiz-main').find('[data-presentations-counter]').text();
                var tot = parseInt($('.presentations__slide')[1].getAttribute('data-tot-slides'));
                if (slideNumber == tot + 1) {
                    console.log('the slide');
                    $('body').on('click', '.presentations__next.active', function(e) {
                        var theElement = $(e.currentTarget).parents('.presentations__quiz-main').find('.confetti-wrapper')[0];
                        addConfetti(theElement);
                    });
                }
            });
        });
        </script>
    <?php
    get_footer('presentation');
    return;
}

get_header('presentation');

while (have_posts()) {
    the_post();
    get_template_part('template-parts/content', 'presentation');
}

get_template_part('components/presentation/mobile-alert');
get_template_part('components/presentation/loading-animation');

get_footer('presentation');
