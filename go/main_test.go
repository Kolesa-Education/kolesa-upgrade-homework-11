package main

import (
	"fmt"
	"testing"

	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/require"
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

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента
	tests := []struct {
		str,
		minor,
		want string
	}{
		{"it was testing", "", "It Was Testing"},
		{"  There was no show", "", "  There Was No Show"},
		{"ALL THE WORDS ARE CAPITAL", "", "All The Words Are Capital"},
	}

	for i, tc := range tests {
		got := titlecase.TitleCase(tc.str, tc.minor)
		errMsg := fmt.Sprintf("Test %d: got Titlecase(\"%v\", \"%v\")= \"%v\", want \"%v\"",
			i, tc.str, tc.minor, got, tc.want)

		require.Equal(t, tc.want, got, errMsg)
	}

}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента

	tests := []struct {
		str,
		minor,
		want string
	}{
		{"simple testing with uncapitalized first world", "simple", "Simple Testing With Uncapitalized First World"},
		{"  there space at the beginning", "there", "  there Space At The Beginning"},
		{"THE first world is capitalized", "THE", "The First World Is Capitalized"},
	}

	for i, tc := range tests {
		got := titlecase.TitleCase(tc.str, tc.minor)
		errMsg := fmt.Sprintf("Test %d: got Titlecase(\"%v\", \"%v\")= \"%v\", want \"%v\"",
			i, tc.str, tc.minor, got, tc.want)

		require.Equal(t, tc.want, got, errMsg)
	}
}

func TestSeveralMinors(t *testing.T) {
	// передайте несколько слов исходной строки в качестве второго аргумента

	tests := []struct {
		str,
		minor,
		want string
	}{

		{"there are several minores at the sentence", "are at the", "There are Several Minores at the Sentence"},
		{"first word with another minor", "with first", "First Word with Another Minor"},
		{"Sentence with no minor", "no, are", "Sentence With No Minor"},
		{"capitalized MINOR example title", "MINOR title", "Capitalized Minor Example title"},
		{"   some space before minor world", "minor some", "   some Space Before minor World"},
		{"all the words are minor", "all the words are minor", "All the words are minor"},
	}

	for i, tc := range tests {
		got := titlecase.TitleCase(tc.str, tc.minor)
		errMsg := fmt.Sprintf("Test %d: got Titlecase(\"%v\", \"%v\")= \"%v\", want \"%v\"",
			i, tc.str, tc.minor, got, tc.want)

		require.Equal(t, tc.want, got, errMsg)
	}
}
