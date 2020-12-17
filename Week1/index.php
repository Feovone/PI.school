<?php
namespace Week1;
include "Article.php";
include "ConverterString.php";
include "DataProcess.php";
include "View.php";
$data = <<< TMAKR
Article:
    Header: BMW AG
    Body: Bayerische Motoren Werk is a German multinational company which currently produces automobiles and motorcycles, and also produced aircraft engines until 1945. The history of the name itself begins with Rapp Motorenwerke, an aircraft engine manufacturer. In April 1917, following the departure of the founder Karl Friedrich Rapp, the company was renamed Bayerische Motoren Werk
    ChangeMap:
        Bayerische Motoren Werk: Bavarian Motor Works(BMW)
    Tags: Automotive Industry, Germany, Luxury
Article:
    Header: Volkswagen
    Body:  Volkswagen is a German automaker founded on 28 May 1937 by the German Labour Front, and headquartered in Wolfsburg. Volkswagen was established in 1937 by the German Labour Front in Berlin.
    ChangeMap:
        Volkswagen: VW
        German: GR
    Tags: Automotive Industry, Germany, Not-Luxury
Article:
    Header: Project E
    Body: Project E was a joint project between the United States and the United Kingdom during the Cold War to provide nuclear weapons to the Royal Air Force (RAF) until sufficient British nuclear weapons became available. It was subsequently expanded to provide similar arrangements for the British Army of the Rhine
    ChangeMap:
        Project E: P.E.
    Tags: Military Industry, USA
Article:
    Header: Ford Motor Company
    Body: Ford Motor Company is a multinational automaker that has its main headquarter in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903.
    ChangeMap:
        Ford Motor Company: Ford
    Tags: Automotive Industry, USA, Not-Luxury
Article:
    Header: Studebaker US6
    Body: The Studebaker US6 (G630) was a series of 2½-ton 6x6 and 5-ton 6x4 trucks manufactured by the Studebaker Corporation and REO Motor Car Company during World War II. The basic cargo version was designed to transport a 5,000 lb (2,300 kg) cargo load over all types of terrain in all kinds of weather.
    Tags: Heavy Automotive Industry, USA, Not-Luxury
TMAKR;

$convertedData = new ConverterString($data);
$processedData = new DataProcess($convertedData->getArticleArray(), "Automotive Industry");
$view = new View($processedData);
$view->htmlPost();
