package main

import (
	"testing"

	"github.com/kulti/titlecase"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

var DataProvider = []struct {
	Str, Minor, Want string
}{
	{"", "", ""},
	{"test text", "", "Test Text"},
	{"test text", "test", "Test Text"},
	{"", "test", ""},                        //first empty
	{"test text", "test text", "Test text"}, //same text as first and second args
	{"1 2 3", "2", "1 2 3"},                 //numbers
	{"! @ #", "@", "! @ #"},                 //symbols
	{"test this simple text", "text this simple", "Test this simple text"}, //disordered words
	{"test text", "AAAAA", "Test Text"},                                    //second arg isn't substring
	{"test text", "TEST TEXT", "Test Text"},                                //second arg is case-sensitive
	{"TEST UPPERCASE uppercase", "uppercase", "Test uppercase uppercase"},  //first arg isn't case-sensitive
}

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента
	const str, minor, want = "test text", "", "Test Text"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента
	const str, minor, want = "test text", "test", "Test Text"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithDataProvider(t *testing.T) {
	for _, dataset := range DataProvider {
		got := titlecase.TitleCase(dataset.Str, dataset.Minor)
		if got != dataset.Want {
			t.Errorf("TitleCase(%v, %v) = %v; want %v", dataset.Str, dataset.Minor, got, dataset.Want)
		}
	}
}
